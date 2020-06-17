<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\KelasCollection as KelasResource;
use App\Kelas;
use App\Mlearningkelas;
use App\Mlearningsiswa;
use Validator;

class KelasController extends BaseController{

    public function kelas(){
        $data = Kelas::all();
        return $this->sendResponse(KelasResource::collection($data), 'Raports retrieved successfully.');
    }

    public function index(){
        $data =  Mlearningkelas::with(['user', 'matapelajaran', 'kelas'])->get();
        return $this->sendResponse(KelasResource::collection($data), 'Raports retrieved successfully.');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'kelas_mlearning_id'  => 'required|integer',
            'siswa_id'            => 'required|integer',
        ]);
        
        if($validator->passes()){
            if(Mlearningsiswa::where('kelas_mlearning_id', $request->kelas_mlearning_id)->where('siswa_id', $request->siswa_id)->count() < 1){
                $data                       = new Mlearningsiswa();
                $data->kelas_mlearning_id   = $request->kelas_mlearning_id;
                $data->siswa_id             = $request->siswa_id;
    
                if($data->save()){
                    $response = 'Data has been saved';
                }else{
                    $response = $validator->errors()->all();
                }
            }else{
                $response = 'Data already exists';
            }
        }

        return $this->sendResponse($response, 'Retrive all data successfully.');

    }
}