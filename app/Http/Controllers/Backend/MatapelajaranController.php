<?php

namespace App\Http\Controllers\Backend;

use App\Matapelajaran;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class MatapelajaranController extends Controller{
    public function index(){
        $breadcrumbs = [
          ['name'=>"Page"]
        ];
        $config = array(
          "title"        => "Backend Page",
          "title_table"  => "Create Page",
        );
        return view('backend.matapelajaran.index', compact('breadcrumbs', 'config'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'nama_matapelajaran'      => 'required|unique:matapelajarans'
        ]);
    
        if($validator->passes()){
          $data                  = new Matapelajaran();
          $data->nama_matapelajaran      = $request->nama_matapelajaran;

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
          'nama_matapelajaran'  => 'required|unique:matapelajarans,nama_matapelajaran,'.$id,
        ]);
    
        $data = Matapelajaran::find($id);
        if($validator->passes()){
          $data->nama_matapelajaran = $request->nama_matapelajaran;
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
        $data = Matapelajaran::find($id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function datatable(){
        return Datatables::of(Matapelajaran::all())
        ->addColumn('action', function ($row) {
            return '
            <a href="#" title="Edit" data-toggle="modal" data-target="#modalUpdate" data-id="'. $row->id.'" data-name="'. $row->nama_matapelajaran.'" class="btn btn-secondary">Edit</a>
            <a href="#" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" class="btn btn-danger">Delete</a>
            '
            ;
        })
        ->toJson();
    }
}
