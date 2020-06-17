<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Carbon\Carbon;
use Image;
use File;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message){
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404){
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function __construct()
    {
        $this->image_path = storage_path('app/public/images');
        $this->file_path = storage_path('app/public/document');
        if (!File::isDirectory("$this->image_path")) {
            File::makeDirectory("$this->image_path");
        }
    }

    public function uploadimage($file, $dimensions, $fileName = NULL){
        if (!File::isDirectory("$this->image_path/original")) {
          File::makeDirectory("$this->image_path/original");
        }

        if($fileName == NULL){
          $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        }
        Image::make($file)->save($this->image_path . '/original/' . $fileName);

        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($dimensions as $row) {
          //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY
          $canvas = Image::canvas($row[0], $row[1]);
          //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY
          //DENGAN MEMPERTAHANKAN RATIO
          $resizeImage  = Image::make($file)->resize($row[0], $row[1], function($constraint) {
              $constraint->aspectRatio();
          });
          if (!File::isDirectory($this->image_path . '/' . $row[2])) {
              File::makeDirectory($this->image_path . '/' . $row[2]);
          }
          //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
          $canvas->insert($resizeImage, 'center');
          //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
          $canvas->save($this->image_path . '/' . $row[2] . '/' . $fileName);
        }
        return $fileName;
    }

    public function uploaddocument($file){
        if (!File::isDirectory($this->file_path)) {
            File::makeDirectory($this->file_path);
        }
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($this->file_path, $fileName);
        return $fileName;
    }
}
