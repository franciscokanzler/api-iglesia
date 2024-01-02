<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Iglesia;
use App\Models\Miembros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columna = $request->columna ?? 'equipos.id';
        $orden = $request->orden ?? 'asc';
        $nro = $request->nro ?? 5;

        try {
            $equiposQuery = Equipo::join('iglesias', 'equipos.iglesia_id', '=', 'iglesias.id')
                ->select('equipos.*', 'iglesias.nombre as nombre_iglesia')
                ->orderBy($columna, $orden);

            if ($request->filtro != "" && $request->valor != "") {
                $equiposQuery->where($request->filtro, 'LIKE', "%{$request->valor}%");
            }

            $equipos = $equiposQuery->paginate($nro);

            return response()->json([
                'data' => $equipos,
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error función equipo.index: ' . $th->getMessage());
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
        $iglesias = Iglesia::all();
        return response()->json([
            'data' => $iglesias,
        ], 200);
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
            'descripcion' => 'required|string',
            'nombre' => 'required|unique:equipos',
            'correo' => 'required|email|unique:equipos',
            'iglesia_id' => 'required|exists:iglesias,id',
        ];

        $ErrorMessages = [
            'iglesia_id.exists' => 'El iglesia_id es incorrecto ',
            'correo.unique' => 'Estimado usuario, el correo ingresado se encuentra en uso',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $equipo = Equipo::create($request->all());

        return response()->json([
            'data' => $equipo,
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
        $equipo = Equipo::with('iglesia')->where('id',$id)->first();
        return response()->json([
            'data' => $equipo,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipo $equipo)
    {
        $rules = [
            'descripcion' => 'required|string',
            'nombre' => 'required|unique:equipos',
            'correo' => 'required|email|unique:equipos,correo,' . $equipo->id,
            'iglesia_id' => 'required|exists:iglesias,id',
        ];

        $ErrorMessages = [
            'iglesia_id.exists' => 'El iglesia_id es incorrecto ',
            'correo.unique' => 'Estimado usuario, el correo ingresado se encuentra en uso',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $equipo->update($request->all());

        return response()->json([
            'data' => $equipo,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return response()->json([
            'data' => $equipo,
        ], 200);
    }

    public function index_equipo_miembro($id){
        $miembros = Equipo::find($id)->miembros()->get();
        return response()->json([
            'data' => $miembros,
        ], 200);
    }

    public function create_equipo_miembro(Request $request){

        $rules = [
            'ci' => 'required|integer',
        ];

        $ErrorMessages = [
            'ci.required' => 'La cédula de identidad es requerida ',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $miembro = Miembros::where('ci',$request->ci)->get();
        /* dd($miembro[0]->id); */
        $representado = Miembros::where('id_representante',$miembro[0]->id)->get();

        return response()->json([
            'miembro' => $miembro,
            'representado' => $representado
        ], 200);
    }

    public function store_equipo_miembro(Request $request){

        $rules = [
            'equipo_id' => 'required|integer',
            'miembro_id' => 'required|integer',
        ];

        $ErrorMessages = [
            'equipo_id.required' => 'El equipo es requerido ',
            'miembro_id.required' => 'El miembro es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $equipo = Equipo::findOrFail($request->equipo_id);
        if (!$equipo->miembros->contains($request->miembro_id)) {
            $miembro = Miembros::findOrFail($request->miembro_id);
            $equipo->miembros()->attach($miembro);
            return response()->json([
                'data' => $equipo,
            ], 200);
        }else{
            return response()->json([
                /* especificar */
                'created' => false,
            ], 400);
        }
        /* $equipo->miembros()->sync($miembro); actualizar*/
        /* $equipo->miembros()->detach($miembro); borrar*/
    }

    public function destroy_equipo_miembro(Equipo $equipo, Miembros $miembro)
    {
        $equipo->miembros()->detach([$miembro->id]);
        return response()->json([
            'delete' => true,
            'e' => $equipo,
            'm' => $miembro,
        ], 200);
    }
}

