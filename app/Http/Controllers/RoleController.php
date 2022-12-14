<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
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

        $rol = Role::create($request->all());

        return response()->json([
            'data' => $rol,
        ], 200);
    }

    public function edit($id)
    {
        $rol = Role::where('id',$id)->first();
        return response()->json([
            'rol' => $rol,
        ], 200);
    }

    public function update(Request $request, Role $role){

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

        $role->update($request->all());

        return response()->json([
            'rol' => $role,
        ], 200);

    }
}
