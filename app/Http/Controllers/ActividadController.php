<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActividadController extends Controller
{
    public function index(){
        $roles = Actividades::all();
        return response()->json([
            'roles' => $roles,
        ], 200);
    }

    public function store(Request $request){
        $rules = [
            'nombre' => 'required',
            'lugar' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_culminacion' => 'required|date',
            'hora_inicio' => 'required',
            'hora_culminacion' => 'required',
            'estatus_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $actividad = Actividades::create($request->all());

        return response()->json([
            'data' => $actividad,
        ], 200);
    }

    public function edit($id)
    {
        $actividad = Actividades::where('id',$id)->first();
        return response()->json([
            'actividad' => $actividad,
        ], 200);
    }

    public function update(Request $request, $id){

        $rules = [
            'nombre' => 'required',
            'lugar' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_culminacion' => 'required|date',
            'hora_inicio' => 'required',
            'hora_culminacion' => 'required',
            'estatus_id' => 'required',
        ];

        $ErrorMessages = [
            'nombre.required' => 'El nombre es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $act = Actividades::where('id',$id)->first();

        $act->update($request->all());

        return response()->json([
            'data' => $act,
        ], 200);

    }
}
