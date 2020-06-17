<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mlearningkomentar;
use Validator;
use Illuminate\Http\Request;

class KomentarController extends BaseController{

    public function show($id){
        $response  = Mlearningkomentar::where('materi_mlearning_id', $id)->with('user')->orderBy('created_at', 'desc')->get();

        return $this->sendResponse($response, 'Retrive all data successfully.');
    }

    public function store(Request $request){
      $validator = Validator::make($request->all(), [
          'users_id'                => 'required|integer',
          'materi_mlearning_id'     => 'required|integer',
      ]);
      
      if($validator->passes()){
          $data                         = new Mlearningkomentar();
          $data->users_id               = $request->users_id;
          $data->materi_mlearning_id    = $request->materi_mlearning_id;
          $data->komentar               = $request->komentar;

          if($data->save()){
              $response = 'Data has been saved';
          }else{
              $response = $validator->errors()->all();
          }
      }
      

      return $this->sendResponse($response, 'Retrive all data successfully.');
    }

  
    public function destroy($id){
      $data = Mlearningkomentar::find($id);
      if($data->delete()){
        $response = 'Data has been saved';

      }
      return $this->sendResponse($response, 'Retrive all data successfully.');
    }



}
