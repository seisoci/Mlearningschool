<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends BaseController{

    public function kelas(Request $request){
        $response  = User::where('id', $request->user()->id)->with(['mlearningsiswa.mlearningkelas', 'mlearningsiswa.mlearningkelas.kelas', 'mlearningsiswa.mlearningkelas.matapelajaran', 'mlearningsiswa.mlearningkelas.user'])->first();

        return $this->sendResponse($response, 'Retrive all data successfully.');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
          'name'      => 'required',
          'email'     => 'required',
          'nis'       => 'required',
          'password'  => 'required|between:6,255',
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
            $data->role       = 'siswa';
            $data->kelas      = $request->kelas;
            $data->api_token  = Str::random(80);

            isset($request->image) && !empty($request->image) ? $data->image = $this->uploadimage($request->image, $dimensions) : NULL;
            if($data->save()){
                $response = $this->sendResponse($data, 'User register successfully.');
            }else{
                $response = $this->sendError($data, 'Error. email/nik sudah terdaftar');
            }

        }else{
            $response = response()->json(['error'=>$validator->errors()->all()]);
        }
        return $response;
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user()->makeVisible(['api_token']);
            return $this->sendResponse($user, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
        // return response()->json($request);
    }

}