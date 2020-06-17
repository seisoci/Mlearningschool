<?php

namespace App\Http\Controllers\Backend;

use App\Kelas;
use App\Mlearningkelas;
use App\Mlearningsiswa;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    public function index(){
        $breadcrumbs = [
          ['name'=>"User"]
        ];
        $config = array(
          "title"        => "Backend User",
          "title_table"  => "Table User"
        );
    
        return view('backend.user.index', compact('breadcrumbs', 'config'));
    }

    public function create(){
        $breadcrumbs = [
            ['link'=>"/user",'name'=>"User"],['name'=>"Create"]
        ];
        $config = array(
            "title"        => "Create User",
            "title_table"  => "Create User"
        );
        $kelas =  Kelas::all();
        return view('backend.user.create', compact('breadcrumbs','config', 'kelas'));
    }
    
    public function edit($id){
        $breadcrumbs = [
          ['link'=>"/backend/user",'name'=>"User"],['name'=>"Edit Form User"]
        ];
        $config = array(
          "title"        => "Edit Form User",
          "title_table"  => "Edit Form User",
        );
        $data = User::findOrFail($id);
        if(Auth::user()->role == 'guru'){
            if($data->role == 'admin'|| ($data->role == 'guru'  && $data->id != Auth::id())){
                return redirect('backend/user');
            }
        }
        $kelas = Kelas::all();
        return view('backend.user.edit', compact('breadcrumbs', 'data', 'config', 'kelas'));
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'name'      => 'required',
          'email'     => 'required',
          'nis'       => 'required',
          'password'  => 'required|between:6,255|confirmed',
          'kelas'     => '',
          'image'     => 'image|mimes:jpg,png,jpeg'
        ]);
    
        if($validator->passes()){
            $dimensions       = [array('300', '300', 'small')];
            $data             = new User();
            $data->name       = $request->name;
            $data->email      = $request->email;
            $data->nis        = $request->nis;
            $data->password   = Hash::make($request->password);
            $data->role       = Auth::user()->role == 'guru' ? 'siswa' : $request->role;
            $data->kelas      = $request->kelas;
            $data->api_token  = Str::random(80);

            isset($request->image) && !empty($request->image) ? $data->image = $this->uploadimage($request->image, $dimensions) : NULL;
            if($data->save()){
                $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
                ]);
            }
        }else{
            $response = response()->json(['error'=>$validator->errors()->all()]);
         }
         return $response;
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required',
            'nis'       => 'required',
            'kelas'     => '',
            'image'     => 'image|mimes:jpg,png,jpeg'
        ]);
    
        $data = User::find($id);
        if($validator->passes()){
          $dimensions       = [array('300', '300', 'small')];
          $data->name       = $request->name;
          $data->email      = $request->email;
          $data->nis        = $request->nis;
          $data->role       = Auth::user()->role == 'guru' ? 'siswa' : $request->role;
          $data->kelas      = $request->kelas;
          $data->api_token  = Str::random(80);

          if(isset($request->image) && !empty($request->image)){
            $base_path = "public/images";
            Storage::delete(["$base_path/original/$data->image", "$base_path/small/$data->image"]);
            $data->image    = $this->uploadimage($request->image, $dimensions);
          }
    
          if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
          }
        }else{
         $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;
    }

    public function destroy($id){
        $data = User::find($id);
        if(Auth::user()->role == 'guru'){
            if($data->role  == 'admin' OR 'guru'){
                $response = response()->json([
                    'status' => 'error',
                    'message' => 'Data cannot be deleted, need permission'
                ]);
                return $response;
            }
        }
        $base_path = "public/images";
        Storage::delete(["$base_path/original/$data->image", "$base_path/small/$data->image"]);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function resetpassword(Request $request){
        $validator = Validator::make($request->all(), [
          'id'        => 'required|integer',
        ]);
    
        if($validator->passes()){
          $data = User::find($request->id);
          $data->password = Hash::make('12345678');
          if($data->save()){
              $response = response()->json([
                  'status' => 'success',
                  'message' => 'Data has been saved'
              ]);
          }
        }else{
          $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;
    }

    public function changepassword(Request $request, $id){
        $validator = Validator::make($request->all(), [
          'old_password' => ['required', new MatchOldPassword($id)],
          'password'     => 'required|between:6,255|confirmed',
        ]);
    
    
        if($validator->passes()){
          $data = User::find($id);
          $data->password = Hash::make($request->password);
          if($data->save()){
              $response = response()->json([
                  'status' => 'success',
                  'message' => 'Data has been saved'
              ]);
          }
        }else{
          $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;
    }

    public function datatable(){
        $datatable = User::all();
        if(Auth::user()->role == 'guru'){
            $datatable = User::where('role', '=', 'siswa')->get();
        }
        return Datatables::of($datatable)
        ->addColumn('action', function ($row) {
          return '
            <a href="" title="Reset Password" data-toggle="modal" data-target="#modalReset" data-id="'. $row->id.'" class="btn btn-success">Reset Pass</a>
            <a href="user/'.$row->id.'/edit" title="Edit" class="btn btn-secondary">Edit</a>
            <a href="#" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" class="btn btn-danger">Delete</a>
            ';
        })->editColumn('image', function(User $user){
            return $user->image != NULL ? asset("storage/images/small/$user->image") : asset("images/noimage.svg");
        })
        ->toJson();
    }
    
}
