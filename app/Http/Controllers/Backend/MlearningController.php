<?php

namespace App\Http\Controllers\Backend;

use App\Mlearningkelas;
use App\Kelas;
use App\Matapelajaran;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Validator;

class MlearningController extends Controller{
    public function index(){
        $breadcrumbs = [
          ['name'=>"Page"]
        ];
        $config = array(
          "title"        => "Backend Page",
          "title_table"  => "Create Page",
        );
        $data = array(
            "kelas"         => Kelas::all(),
            "matapelajaran" => Matapelajaran::all(),
            "guru"          => User::where('role', 'guru')->get(),
        );
        return view('backend.mlearning.index', compact('breadcrumbs', 'config', 'data'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'guru_id'             => 'integer',
          'kelas_id'            => 'required|integer',
          'matapelajaran_id'    => 'required|integer',
          'tahun'               => 'required|integer',
        ]);
    
        if($validator->passes()){
          $data                     = new Mlearningkelas();
          $data->guru_id            = Auth::user()->role == 'guru' ? Auth::id() : $request->guru_id;
          $data->kelas_id           = $request->kelas_id;
          $data->matapelajaran_id   = $request->matapelajaran_id;
          $data->jurusan            = $request->jurusan;
          $data->tahun              = $request->tahun;
          
          if(Mlearningkelas::where('guru_id', $data->guru_id)->where('kelas_id', $data->kelas_id)->where('matapelajaran_id', $data->matapelajaran_id)->where('jurusan', $request->jurusan)->where('tahun', $request->tahun)->count() < 1){
            if($data->save()){
                $response = response()->json([
                    'status' => 'success',
                    'message' => 'Data has been saved'
                ]);
              }
          }else{
            $response = response()->json([
                'status' => 'error',
                'message' => 'Data already exists'
            ]);
          }

         
        }else{
         $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'guru_id'             => 'integer',
            'kelas_id'            => 'required|integer',
            'matapelajaran_id'    => 'required|integer',
            'tahun'               => 'required|integer',
        ]);
    
        if($validator->passes()){
            $data                     = Mlearningkelas::find($id);
            $data->guru_id            = Auth::user()->role == 'guru' ? Auth::id() : $request->guru_id;
            $data->kelas_id           = $request->kelas_id;
            $data->matapelajaran_id   = $request->matapelajaran_id;
            $data->jurusan            = $request->jurusan;
            $data->tahun              = $request->tahun;
            
            if(Mlearningkelas::where('guru_id', $data->guru_id)->where('kelas_id', $data->kelas_id)->where('matapelajaran_id', $data->matapelajaran_id)->where('jurusan', $request->jurusan)->where('tahun', $request->tahun)->count() < 1){
              if($data->save()){
                  $response = response()->json([
                      'status' => 'success',
                      'message' => 'Data has been saved'
                  ]);
                }
            }else{
              $response = response()->json([
                  'status' => 'error',
                  'message' => 'Data already exists'
              ]);
            }
  
        }else{
        $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;
    }

    public function destroy($id){   
        $data = Mlearningkelas::find($id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function datatable(){
        $datatable = Mlearningkelas::with(['user', 'matapelajaran', 'kelas']);
        if(Auth::user()->role == 'guru'){
            $datatable = Mlearningkelas::with(['user', 'matapelajaran', 'kelas'])->where('guru_id', '=', Auth::id())->get();
        }
        return Datatables::of($datatable)
        ->addColumn('action', function ($row) {
            return '
            <a href="/backend/user/kelas/'.$row->id.'" title="Lihat Siswa" class="btn btn-outline-primary"><i class="c-deep-blue-500 ti-user"></i></a>
            <a href="/backend/mlearningmateri/materi/'.$row->id.'" title="Lihat Materi" class="btn btn-outline-success"><i class="c-deep-blue-500 ti-files"></i></a>
            <a href="#" title="Edit" data-toggle="modal" data-target="#modalUpdate" data-id="'. $row->id.'" data-guru_id="'. $row->user['id'].'" data-kelas_id="'. $row->kelas['id'].'" data-matapelajaran_id="'. $row->matapelajaran['id'].'" data-jurusan="'. $row->jurusan.'" data-tahun="'.$row->tahun.'" class="btn btn-outline-secondary">Edit</a>
            <a href="#" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" class="btn btn-outline-danger">Delete</a>
            '
            ;
        })
        ->toJson();
    }
}
