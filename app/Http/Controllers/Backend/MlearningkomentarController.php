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

class MlearningkomentarController extends Controller{

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'users_id'                => 'required|integer',
          'materi_mlearning_id'     => 'required|integer',
        ]);
    
        if($validator->passes()){
            $data                       = new Mlearningkomentar();
            $data->users_id             = $request->users_id;
            $data->materi_mlearning_id  = $request->materi_mlearning_id;
            $data->komentar             = $request->komentar;

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
        $data = Mlearningkomentar::find($id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function komentar($id){

        $data = array(
            // 'siswa' => Mlearningkelas::with('mlearningsiswa', 'mlearningsiswa.user')->find($id),
            'kelas_mlearning_id'    => $id,
            'kelas'                 => Mlearningmateri::with(['kelas.user', 'kelas.matapelajaran', 'kelas.kelas'])->where('id', $id)->first(),
            'materi'                => Mlearningmateri::where('id', $id)->first(),
            'komentar'              => Mlearningkomentar::with('user')->where('materi_mlearning_id', $id)->orderBy('created_at', 'DESC')->paginate(20),
        );

        // return $data['kelas']->toJson();
        return view('backend.mlearningkomentar.index', compact('data'));
    }
    
}
