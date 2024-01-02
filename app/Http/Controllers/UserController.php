<?php

namespace App\Http\Controllers;

use App\Models\Miembros;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function login(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required',
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
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
            /* return response(['token'=>$token],Response::HTTP_OK); */
        }else{
            return response()->json([
                'mensaje' => 'Credenciales Inválidas',
            ], 400);
            /* return response(['mensaje'=>'Credenciales Inválidas'],Response::HTTP_UNAUTHORIZED); */
        }
    }

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

        $user = User::create([
            'name' => $request['name'],
            'email'=> $request['email'],
            'password'=> bcrypt($request['password']),
            'miembro_id' => $request['miembro_id'],
            'estatus_id'=> $request['estatus_id'],
            'role_id'=> $request['role_id'],
        ]);

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

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'mensaje' => 'cierre de sesion exitoso',
        ], 200);
    }
}
