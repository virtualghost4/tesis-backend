<?php

namespace App\Http\Controllers;

use App\FotoDaño;
use App\Servicio;
use App\User;
use Illuminate\Http\Request;
use Gate,Validator,Storage;
use Illuminate\Validation\ValidationException;

class FotoDanoController extends Controller
{
    public function uploadPhoto(Request $request,$id){
        $service = Servicio::find($id);
        $user = User::find($request->user()->id);

        if ($service->id_chofer == $user->chofer->id){

            $rules = [
                'foto'          => 'required|image|dimensions:max_width=4500,max_height=2500'
            ];

            $data = $request->only(['foto']);

            try {
                $validator = Validator::make($data, $rules);
            } catch (ValidationException $e) {
                return response()->json(['message'=>'Hay errores en tus datos','errors'=>$e->errors()]);
            }
            if ($validator->fails()){
                return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()]);
            }

            $photo = $request->file('foto');
            $nombre = 'niru_'.md5(time()).'.'.$photo->getClientOriginalExtension();

            $result = $request->foto->storeAs('damage-photo',$nombre,'s3');
            //Storage::disk('s3')->put('damage-photo/',$photo);

            $damagePhoto = new FotoDaño();

            $damagePhoto->url           = env('AWS_CLOUDFRONT_IMAGE_DOMAIN').'/'.$nombre;
            $damagePhoto->id_servicio   = $id;
            $damagePhoto->bucket_url    = $result;
            $damagePhoto->save();

            return response()->json(['message'=>'Foto guardada con exito', 'resultado' => $result],201);
        }
        return response('Operacion no permitida',403);
    }
}
