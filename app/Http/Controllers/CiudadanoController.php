<?php

namespace App\Http\Controllers;

use App\Models\Ciudadano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CiudadanoController extends Controller
{
    public function index()
    {
        $ec = Ciudadano::all();
        return response()->json([
            'data' => $ec,
        ], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|unique:ciudadanos',
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

        $EstadoCivil = Ciudadano::create($request->all());

        return response()->json([
            'data' => $EstadoCivil,
        ], 200);
    }

    public function edit($id)
    {
        $ec = Ciudadano::where('id',$id)->get();
        return response()->json([
            'data' => $ec,
        ], 200);
    }

    public function update(Request $request, Ciudadano $ciudadano){

        $rules = [
            'nombre' => 'required|unique:iglesias',
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

        $ciudadano->update($request->all());

        return response()->json([
            'data' => $ciudadano,
        ], 200);

    }
}
