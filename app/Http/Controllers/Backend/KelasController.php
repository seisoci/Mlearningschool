<?php

namespace App\Http\Controllers\Backend;

use App\Kelas;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class KelasController extends Controller{
    public function index(){
        $breadcrumbs = [
          ['name'=>"Page"]
        ];
        $config = array(
          "title"        => "Backend Page",
          "title_table"  => "Create Page",
        );
        return view('backend.kelas.index', compact('breadcrumbs', 'config'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'nama_kelas'      => 'required|unique:kelas'
        ]);
    
        if($validator->passes()){
          $data                  = new Kelas();
          $data->nama_kelas      = $request->nama_kelas;

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
          'nama_kelas'  => 'required|unique:kelas,nama_kelas,'.$id,
        ]);
    
        $data = Kelas::find($id);
        if($validator->passes()){
          $data->nama_kelas = $request->nama_kelas;
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
        $data = Kelas::find($id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function datatable(){
        return Datatables::of(Kelas::all())
        ->addColumn('action', function ($row) {
            return '
            <a href="#" title="Edit" data-toggle="modal" data-target="#modalUpdate" data-id="'. $row->id.'" data-name="'. $row->nama_kelas.'" class="btn btn-secondary">Edit</a>
            <a href="#" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" class="btn btn-danger">Delete</a>
            '
            ;
        })
        ->toJson();
    }
}
