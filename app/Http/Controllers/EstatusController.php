<?php

namespace App\Http\Controllers;

use App\Models\Estatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstatusController extends Controller
{
    public function index(){
        $estatus = Estatus::all();
        return response()->json([
            'data' => $estatus,
        ], 200);
    }

    public function store(Request $request){
        $rules = [
            'nombre' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $estatus = Estatus::create($request->all());

        return response()->json([
            'data' => $estatus,
        ], 200);
    }

    public function edit($id)
    {
        $rol = Estatus::where('id',$id)->first();
        return response()->json([
            'rol' => $rol,
        ], 200);
    }

    public function update(Request $request, Estatus $estatus){

        $rules = [
            'nombre' => 'required',
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

        $estatus->update($request->all());

        return response()->json([
            'estatus' => $estatus,
        ], 200);

    }
}
