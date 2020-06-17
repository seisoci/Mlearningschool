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

class MlearningsiswaController extends Controller{

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
          'kelas_mlearning_id'      => 'required|integer',
          'siswa_id'                => 'required|integer',
        ]);
    
        if($validator->passes()){
            $data                       = new Mlearningsiswa();
            $data->kelas_mlearning_id   = $request->kelas_mlearning_id;
            $data->siswa_id             = $request->siswa_id;

            if(Mlearningsiswa::where('kelas_mlearning_id', $data->kelas_mlearning_id)->where('siswa_id', $data->siswa_id)->count() < 1){
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
        $data = Mlearningsiswa::find($id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function kelasmlearning($id){
        $collection  =  Mlearningsiswa::where('kelas_mlearning_id', $id)->get();
        $plucked     = collect($collection)->pluck('siswa_id');

        $data = array(
            // 'siswa' => Mlearningkelas::with('mlearningsiswa', 'mlearningsiswa.user')->find($id),
            'kelas_mlearning_id'    => $id,
            'siswa'                 => Mlearningsiswa::where('kelas_mlearning_id', $id)->with('user')->paginate(18),
            'user_siswa'            => User::where('role', 'siswa')->whereNotIn('id', $plucked)->get(),
            'kelas'                 => Mlearningkelas::with(['user', 'matapelajaran', 'kelas'])->where('id', $id)->first(),
        );

        // $query = User::where('role', 'siswa')->get();
        // $collection = collect($query)->except([3,4]);


        // return response()->json($collection);
        // dd($data['kelas']);
        return view('backend.mlearning.siswa', compact('data'));
    }
    
}
