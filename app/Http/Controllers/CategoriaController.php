<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index(){
        $roles = Categorias::all();
        return response()->json([
            'roles' => $roles,
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

        $categoria = Categorias::create($request->all());

        return response()->json([
            'data' => $categoria,
        ], 200);
    }

    public function edit($id)
    {
        $categoria = Categorias::where('id',$id)->first();
        return response()->json([
            'categoria' => $categoria,
        ], 200);
    }

    public function update(Request $request, Categorias $categoria){

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

        $categoria->update($request->all());

        return response()->json([
            'categoria' => $categoria,
        ], 200);

    }
}
