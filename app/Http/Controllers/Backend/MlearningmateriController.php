<?php

namespace App\Http\Controllers\Backend;

use App\Kelas;
use App\Mlearningkelas;
use App\Mlearningkomentar;
use App\Mlearningmateri;
use App\Mlearningsiswa;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;
use DataTables;

class MlearningmateriController extends Controller{

    public function createmateri($id){
        $breadcrumbs = [
            ['link'=>"/materi",'name'=>"Materi"],['name'=>"Create"]
        ];
        $config = array(
            "title"        => "Create Materi",
            "title_table"  => "Create Materi"
        );
        // dd($id);
        return view('backend.mlearningmateri.create', compact('breadcrumbs','config', 'id'));
    }

    public function editmateri($id){
        $breadcrumbs = [
            ['link'=>"/backend/materi",'name'=>"Materi"],['name'=>"Edit Form Materi"]
        ];
        $config = array(
        "title"        => "Edit Form Materi",
        "title_table"  => "Edit Form Materi",
        );
        $data = Mlearningmateri::findOrFail($id);
        return view('backend.mlearningmateri.edit', compact('breadcrumbs', 'data', 'id'));
    }

    public function updatemateri(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'kelas_mlearning_id'  => 'required',
            'judul'               => 'required',
            'image'               => 'image|mimes:jpg,png,jpeg',
            'image2'              => 'image|mimes:jpg,png,jpeg',
            'image3'              => 'image|mimes:jpg,png,jpeg'
        ]);
    
        $data = Mlearningmateri::find($id);
        if($validator->passes()){
          $dimensions       = [array('1200', '800', 'small')];
          $data->kelas_mlearning_id = $request->kelas_mlearning_id;
          $data->judul      = $request->judul;
          $data->deskripsi  = $request->deskripsi;

          if(isset($request->image) && !empty($request->image)){
            $base_path = "public/images";
            Storage::delete(["$base_path/original/$data->image", "$base_path/small/$data->image"]);
            isset($request->image) && !empty($request->image) ? $data->image = $this->uploadimage($request->image, $dimensions) : NULL;   
          }
          if(isset($request->image2) && !empty($request->image2)){
            $base_path = "public/images";
            Storage::delete(["$base_path/original/$data->image_2", "$base_path/small/$data->image_2"]);
            isset($request->image2) && !empty($request->image2) ? $data->image_2 = $this->uploadimage($request->image2, $dimensions) : NULL; 
          }
          if(isset($request->image3) && !empty($request->image3)){
            $base_path = "public/images";
            Storage::delete(["$base_path/original/$data->image_3", "$base_path/small/$data->image_3"]);
            isset($request->image3) && !empty($request->image3) ? $data->image_3 = $this->uploadimage($request->image3, $dimensions) : NULL;    
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

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'kelas_mlearning_id'  => 'required',
          'judul'               => 'required',
          'image'               => 'image|mimes:jpg,png,jpeg',
          'image2'              => 'image|mimes:jpg,png,jpeg',
          'image3'              => 'image|mimes:jpg,png,jpeg'
        ]);
    
        if($validator->passes()){
            $dimensions       = [array('1200', '800', 'small')];
            $data             = new Mlearningmateri();
            $data->kelas_mlearning_id = $request->kelas_mlearning_id;
            $data->judul      = $request->judul;
            $data->deskripsi  = $request->deskripsi;

            isset($request->image) && !empty($request->image) ? $data->image = $this->uploadimage($request->image, $dimensions) : NULL;
            isset($request->image2) && !empty($request->image2) ? $data->image_2 = $this->uploadimage($request->image2, $dimensions) : NULL;
            isset($request->image3) && !empty($request->image3) ? $data->image_3 = $this->uploadimage($request->image3, $dimensions) : NULL;
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
        $data = Mlearningmateri::find($id);
        $base_path = "public/images";
        Storage::delete(["$base_path/original/$data->image", "$base_path/small/$data->image", "$base_path/original/$data->image_2", "$base_path/small/$data->image_2", "$base_path/original/$data->image_3", "$base_path/small/$data->image_3"]);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function materi($id){

        $data = array(
            // 'siswa' => Mlearningkelas::with('mlearningsiswa', 'mlearningsiswa.user')->find($id),
            // 'kelas_mlearning_id'    => $id,
            // 'siswa'                 => Mlearningsiswa::where('kelas_mlearning_id', $id)->with('user')->paginate(18),
            // 'user_siswa'            => User::where('role', 'siswa')->get(),
            'kelas'                 => Mlearningkelas::with(['user', 'matapelajaran', 'kelas'])->where('id', $id)->first(),
        );
        return view('backend.mlearningmateri.index', compact('id', 'data'));
    }

    public function datatable($id){
        return Datatables::of(Mlearningmateri::with('komentar')->where('kelas_mlearning_id', $id)->get())
        ->addColumn('action', function ($row) {
          return '
            <a href="/backend/mlearningmateri/komentar/'.$row->id.'" title="Lihat Materi" class="btn btn-outline-primary"><i class="c-deep-gray-500 ti-comment"></i> '.$row->komentar->count().' Komentar</a>
            <a href="/backend/mlearningmateri/materi/'.$row->id.'/edit" title="Edit" class="btn btn-secondary">Edit</a>
            <a href="#" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" class="btn btn-danger">Delete</a>
            ';
        })
        ->toJson();
    }
    
}
