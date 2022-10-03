<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoCivilController extends Controller
{
    public function store(Request $request)
    {
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

        $EstadoCivil = EstadoCivil::create($request->all());

        return response()->json([
            'data' => $EstadoCivil,
        ], 200);
    }
}
