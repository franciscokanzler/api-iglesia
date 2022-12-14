<?php

namespace App\Http\Controllers;

use App\Models\Miembros;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return response()->json([
            'data' => $usuarios,
        ], 200);
    }

    public function create($ci){
        $miembro = Miembros::where('ci',$ci)->get();
        $representado = Miembros::where('id_representante',$miembro[0]->id)->get();
        return response()->json([
            'miembro' => $miembro,
            'representado' => $representado
        ], 200);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'miembro_id' => 'required',
            'estatus_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $user = User::create($request->all());

        return response()->json([
            'data' => $user,
        ], 200);
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        return response()->json([
            'usuario' => $user,
        ], 200);
    }

    public function update(Request $request, User $usuario){

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'miembro_id' => 'required',
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

        $usuario->update($request->all());

        return response()->json([
            'usuario' => $usuario,
        ], 200);

    }
}
