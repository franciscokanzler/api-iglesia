<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IglesiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iglesia = Iglesia::all();
        return response()->json([
            'data' => $iglesia,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|unique:iglesias',
            'correo' => 'required|email|unique:iglesias',
            'fecha_creacion' => 'date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $iglesia = Iglesia::create($request->all());

        return response()->json([
            'data' => $iglesia,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $iglesia = Iglesia::where('id',$id)->get();
        return response()->json([
            'data' => $iglesia,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iglesia $iglesia)
    {
        $rules = [
            'nombre' => 'required|unique:iglesias',
            'correo' => 'required|email',
            'fecha_creacion' => 'date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $iglesia->update($request->all());

        return response()->json([
            'data' => $iglesia,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iglesia $iglesia)
    {
        $iglesia->delete();
        return response()->json([
            'data' => $iglesia,
        ], 200);
    }
}
