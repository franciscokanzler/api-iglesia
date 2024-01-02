<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IglesiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columna = $request->columna ?? 'miembros.id';
        $orden = $request->orden ?? 'asc';
        $nro = $request->nro ?? 5;

        try {
            $iglesiasQuery = $request->role_id == 1 ? Iglesia::orderBy($columna, $orden) : Iglesia::orderBy($columna, $orden)->where('user_id', $request->id);
            if ($request->role_id == 1) {
                $iglesiasQuery = Iglesia::orderBy($columna, $orden);
            }else if ($request->role_id == 2) {
                $iglesiasQuery = Iglesia::orderBy($columna, $orden)->where('user_id', $request->id);
            }else if ($request->role_id == 3){
                $iglesia = Iglesia::miembros()->where('id',$request->miembro_id);
                $iglesiasQuery = Iglesia::orderBy($columna, $orden);
            }

            if ($request->filtro != "" && $request->valor != "") {
                $iglesiasQuery->where($request->filtro, 'LIKE', "%{$request->valor}%");
            }

            $iglesias = $iglesiasQuery->paginate($nro);

            return response()->json([
                'data' => $iglesias,
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error función iglesia.index: ' . $th->getMessage());
            Log::error('Archivo: ' . $th->getFile());
            Log::error('Línea: ' . $th->getLine());
            return response()->json([
                'errors'  => 'Estimado usuario, en estos momentos no se puede procesar su solicitud'
            ], 400);
        }
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
            'nombre' => 'required',
            'correo' => 'required|email|unique:iglesias',
            'fecha_creacion' => 'nullable|date',
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
            'nombre' => 'required',
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
