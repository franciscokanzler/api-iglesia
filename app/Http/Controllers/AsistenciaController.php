<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AsistenciaController extends Controller
{
    public function index(){
        $asistencias = Asistencia::all();
        return response()->json([
            'asistencias' => $asistencias,
        ], 200);
    }

    public function store(Request $request){
        $rules = [
            'actividad_id' => 'required',
            'miembro_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $asistencia = Asistencia::create($request->all());

        return response()->json([
            'data' => $asistencia,
        ], 200);
    }

    public function edit($id)
    {
        $asistencia = Asistencia::where('id',$id)->first();
        return response()->json([
            'asistencia' => $asistencia,
        ], 200);
    }

    public function update(Request $request, Asistencia $asistencia){

        $rules = [
            'actividad_id' => 'required',
            'miembro_id' => 'required',
        ];

        $ErrorMessages = [
            'actividad_id.required' => 'La actividad es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $asistencia->update($request->all());

        return response()->json([
            'asistencia' => $asistencia,
        ], 200);

    }
}
