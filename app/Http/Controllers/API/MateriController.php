<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mlearningmateri;

class MateriController extends BaseController{

    public function materi($id){
        $response  = Mlearningmateri::where('kelas_mlearning_id', $id)->orderBy('created_at', 'desc')->get();

        return $this->sendResponse($response, 'Retrive all data successfully.');
    }


}
