<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request){
        $rules = [
            'mensaje' => 'required',
            'post_id' => 'required',
            'user_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $comentario = Comentario::create($request->all());

        return response()->json([
            'data' => $comentario,
        ], 200);
    }

    public function edit($id)
    {
        $comentario = Comentario::where('id',$id)->first();
        return response()->json([
            'actividad' => $comentario,
        ], 200);
    }

    public function update(Request $request, $id){
        $rules = [
            'mensaje' => 'required',
            'post_id' => 'required',
            'user_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $comentario = Comentario::where('id',$id)->first();

        $comentario->update($request->all());

        return response()->json([
            'data' => $comentario,
        ], 200);
    }

    public function destroy($id){
        $comentario = Comentario::where('id',$id);
        $comentario->delete();
        return response()->json([
            'delete' => true,
        ], 200);
    }
}
