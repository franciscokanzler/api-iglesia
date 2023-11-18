<?php

namespace App\Http\Controllers;

use App\Models\Ciudadano;
use App\Models\Estado;
use App\Models\Iglesia;
use App\Models\Miembros;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Rango;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MiembroController extends Controller
{
    public function index(){
        $miembros = Miembros::with('iglesia')->get();
        return response()->json([
            'miembros' => $miembros,
        ], 200);
    }

    public function create(){
        $iglesia = Iglesia::all();
        $rango = Rango::all();
        $EstadoCivil = Ciudadano::all();
        $estado = Estado::all();
        return response()->json([
            'iglesia' => $iglesia,
            'rango' => $rango,
            'estadocivil' => $EstadoCivil,
            'estado' => $estado,
        ], 200);
    }

    public function municipios($id){
        $municipio = Municipio::where('id_estado',$id)->get();
        return response()->json([
            'municipio' => $municipio,
        ], 200);
    }

    public function parroquias($id){
        $parroquia = Parroquia::where('id_municipio',$id)->get();
        return response()->json([
            'parroquia' => $parroquia,
        ], 200);
    }

    public function store(Request $request)
    {
        $date = Carbon::parse($request->fecha_nacimiento);
        $request['edad'] = Carbon::createFromDate($date)->age;
        /* dd($request->all()); */
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|unique:miembros',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|integer',
            'iglesia_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'municipio_id' => 'required|integer',
            'parroquia_id' => 'nullable|integer',
            'id_representante' => 'nullable|numeric|required_without:ci|required_if:edad,<,18',
            'estado_civil_id' => 'nullable|required_if:ci,!=,null|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $miembro = Miembros::create($request->all());

        return response()->json([
            'data' => $miembro,
        ], 200);
    }

    public function edit($id)
    {
        $miembro = Miembros::where('id',$id)->first();
        $iglesia = Iglesia::where('id',$miembro->iglesia_id)->get();
        $rango = Rango::where('id',$miembro->rango_id)->get();
        $EstadoCivil = Ciudadano::where('id',$miembro->estado_civil_id)->get();
        $estado = Estado::where('id',$miembro->estado_id)->get();
        return response()->json([
            'miembro' => $miembro,
            'iglesia' => $iglesia,
            'rango' => $rango,
            'estadocivil' => $EstadoCivil,
            'estado' => $estado,
        ], 200);

        return response()->json([
            'data' => $miembro,
        ], 200);
    }

    public function update(Request $request, Miembros $miembro){

        $date = Carbon::parse($request->fecha_nacimiento);
        $request['edad'] = Carbon::createFromDate($date)->age;
        /* dd($request->all()); */
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|unique:miembros',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|integer',
            'iglesia_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'municipio_id' => 'required|integer',
            'parroquia_id' => 'required|integer',
            'id_representante' => 'required_if:ci,null|integer',
            'estado_civil_id' => 'required_if:ci,!=,null|integer',
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

        $miembro->update($request->all());

        return response()->json([
            'data' => $miembro,
        ], 200);

    }
}
