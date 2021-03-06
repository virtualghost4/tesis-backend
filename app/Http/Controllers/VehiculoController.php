<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->user()->id);

        $vehiculos = $user->cliente->vehiculos;

        return response()->json($vehiculos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientId = User::find($request->user()->id)->cliente;

        $data = $request->only(['patente_vehiculo','marca','modelo','color']);
        $rules = [
            'patente_vehiculo'  => 'required',
            'marca'             => 'required',
            'modelo'            => 'required',
            'color'             => 'required',
        ];

        $validator = Validator::make($data,$rules);

        if ($validator->fails()){
            return response(['message'=>'Hay errores en tus entradas','errors'=>$validator->messages()],400);
        }

        $vehiculo = new Vehiculo();
        $vehiculo->patente_vehiculo = $request->patente_vehiculo;
        $vehiculo->marca            = $request->marca;
        $vehiculo->modelo           = $request->modelo;
        $vehiculo->color            = $request->color;
        $vehiculo->id_cliente       = $clientId;

        $vehiculo->save();

        return response()->json(['message'=> 'Vehiculo registrado con exito']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
