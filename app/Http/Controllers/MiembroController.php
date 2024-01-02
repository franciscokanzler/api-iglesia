<?php

namespace App\Http\Controllers;

use App\Models\Ciudadano;
use App\Models\Estado;
use App\Models\Iglesia;
use App\Models\Miembros;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Rango;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MiembroController extends Controller
{
    public function index(Request $request)
    {
        $columna = $request->columna ?? 'miembros.id';
        $orden = $request->orden ?? 'asc';
        $nro = $request->nro ?? 5;

        try {
            $miembrosQuery = Miembros::join('iglesias', 'miembros.iglesia_id', '=', 'iglesias.id')
                ->select('miembros.*', 'iglesias.nombre as nombre_iglesia')
                ->orderBy($columna, $orden);

            if ($request->filtro != "" && $request->valor != "") {
                $miembrosQuery->where($request->filtro, 'LIKE', "%{$request->valor}%");
            }

            $miembros = $miembrosQuery->paginate($nro);

            return response()->json([
                'data' => $miembros,
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error función miembro.index: ' . $th->getMessage());
            Log::error('Archivo: ' . $th->getFile());
            Log::error('Línea: ' . $th->getLine());
            return response()->json([
                'errors'  => 'Estimado usuario, en estos momentos no se puede procesar su solicitud'
            ], 400);
        }
    }

    public function create()
    {
        $iglesia = Iglesia::all();
        $rango = Rango::all();
        $EstadoCivil = Ciudadano::all();
        $estado = Estado::all();
        return response()->json([
            'iglesia' => $iglesia,
            'rango' => $rango,
            'estadocivil' => $EstadoCivil,
            'estado' => $estado,
        ], 200);
    }

    public function municipios($id)
    {
        $municipio = Municipio::where('estado_id', $id)->get();
        return response()->json([
            'municipio' => $municipio,
        ], 200);
    }

    public function parroquias($id)
    {
        $parroquia = Parroquia::where('municipio_id', $id)->get();
        return response()->json([
            'parroquia' => $parroquia,
        ], 200);
    }

    public function representante($ci)
    {
        $representante = Miembros::where('ci', $ci)->with('iglesia')->first();
        return response()->json([
            'representante' => $representante,
        ], 200);
    }

    public function store(Request $request)
    {
        $date = Carbon::parse($request->fecha_nacimiento);
        $request['edad'] = Carbon::createFromDate($date)->age;

        /* dd($request->all()); */
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|unique:miembros',
            'fecha_nacimiento' => 'required|date',
            'ci' => 'nullable|required_if:edad,>,9|unique:miembros',
            'edad' => 'required|integer',
            'iglesia_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'municipio_id' => 'required|integer',
            'parroquia_id' => 'nullable|integer',
            'id_representante' => 'nullable|numeric|required_without:ci|required_if:edad,<,18',
            'estado_civil_id' => 'nullable|required_if:edad,>,9|numeric',
        ];

        $ErrorMessages = [
            'nombre.required' => 'Estimado usuario, el nombre es requerido.',
            'nombre.alpha' => 'Estimado usuario, el campo nombre solo puede contener letras.',
            'apellido.required' => 'Estimado usuario, el apellido es requerido.',
            'apellido.alpha' => 'Estimado usuario, el campo apellido solo puede contener letras.',
            'fechaNacimiento.required' => 'Estimado usuario, la fecha de nacimiento es requerida.',
            'fechaNacimiento.date' => 'Estimado usuario, el formato de fecha ingresado es incorrecto.',
            'ci.regex' => 'Estimado usuario, el campo cédula debe tener el formato V/E-1234567890 y no exceder los 12 caracteres.',
            //'edad.numeric' => 'Estimado usuario, el campo Edad debe ser numérico.',
            'telefono.regex' => 'Estimado usuario, el campo Teléfono debe tener un formato válido de números (ejemplo: 0412-1234567).',
            'correo.required' => 'Estimado usuario, el correo es requerido.',
            'correo.email' => 'Estimado usuario, el formato de correo ingresado es incorrecto.',
            'nro_casa.numeric' => 'Estimado usuario, el campo Número de casa debe ser numérico.',
            'id_representante.numeric' => 'Estimado usuario, el valor del campo Representante es incorrecto.',
            'id_representante.required_without' => 'Estimado usuario, seleccione un Representante.',
            'id_representante.required_if' => 'Estimado usuario, seleccione un Representante..',
            'iglesia_id.required' => 'Estimado usuario, ingrese la iglesia a la cual pertenece.',
            'iglesia_id.numeric' => 'Estimado usuario, el valor del campo Iglesia es incorrecto.',
            'rango_id.numeric' => 'Estimado usuario, el valor del campo Rango es incorrecto.',
            'estado_civil_id.numeric' => 'Estimado usuario, el valor del campo Estado Civil es incorrecto.',
            'estado_id.required' => 'Estimado usuario, ingrese el Estado en el cual reside.',
            'estado_id.numeric' => 'Estimado usuario, el valor del campo Estado es incorrecto.',
            'municipio_id.required' => 'Estimado usuario, ingrese el Municipio en el cual reside.',
            'municipio_id.numeric' => 'Estimado usuario, el valor del campo Municipio es incorrecto.',
            'parroquia_id.required' => 'Estimado usuario, ingrese la Parroquia en la cual reside.',
            'parroquia_id.numeric' => 'Estimado usuario, el valor del campo Parroquia es incorrecto.',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }
        try {
            $miembro = Miembros::create($request->all());

            return response()->json([
                'data' => $miembro,
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error función miembro.store: ' . $th->getMessage());
            Log::error('Archivo: ' . $th->getFile());
            Log::error('Línea: ' . $th->getLine());
            return response()->json([
                'errors'  => 'Estimado usuario, en estos momentos no se puede procesar su solicitud'
            ], 400);
        }
    }

    public function edit($id)
    {
        $miembro = Miembros::where('id', $id)
            ->with(
                'iglesia',
                'rango',
                'estado_civil',
                'estado',
                'municipio',
                'parroquia'
            )
            ->first();

        if ($miembro->edad < 18) {
            $representante = Miembros::where('id', $miembro->id_representante)->with('iglesia')->first();
            $miembro['representante'] = $representante;
        }

        return response()->json([
            'miembro' => $miembro,
        ], 200);
    }

    public function update(Request $request, Miembros $miembro)
    {

        $date = Carbon::parse($request->fecha_nacimiento);
        $request['edad'] = Carbon::createFromDate($date)->age;
        /* dd($request->all()); */
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|unique:miembros,correo,' . $miembro->id,
            'fecha_nacimiento' => 'required|date',
            'ci' => 'nullable|required_if:edad,>,9|unique:miembros,ci,' . $miembro->id,
            'edad' => 'required|integer',
            'iglesia_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'municipio_id' => 'required|integer',
            'parroquia_id' => 'nullable|integer',
            'id_representante' => 'nullable|numeric|required_without:ci|required_if:edad,<,18',
            'estado_civil_id' => 'nullable|required_if:edad,>,9|numeric',
        ];

        $ErrorMessages = [
            'nombre.required' => 'Estimado usuario, el nombre es requerido.',
            'nombre.alpha' => 'Estimado usuario, el campo nombre solo puede contener letras.',
            'apellido.required' => 'Estimado usuario, el apellido es requerido.',
            'apellido.alpha' => 'Estimado usuario, el campo apellido solo puede contener letras.',
            'fechaNacimiento.required' => 'Estimado usuario, la fecha de nacimiento es requerida.',
            'fechaNacimiento.date' => 'Estimado usuario, el formato de fecha ingresado es incorrecto.',
            'ci.regex' => 'Estimado usuario, el campo cédula debe tener el formato V/E-1234567890 y no exceder los 12 caracteres.',
            //'edad.numeric' => 'Estimado usuario, el campo Edad debe ser numérico.',
            'telefono.regex' => 'Estimado usuario, el campo Teléfono debe tener un formato válido de números (ejemplo: 0412-1234567).',
            'correo.required' => 'Estimado usuario, el correo es requerido.',
            'correo.email' => 'Estimado usuario, el formato de correo ingresado es incorrecto.',
            'nro_casa.numeric' => 'Estimado usuario, el campo Número de casa debe ser numérico.',
            'id_representante.numeric' => 'Estimado usuario, el valor del campo Representante es incorrecto.',
            'id_representante.required_without' => 'Estimado usuario, seleccione un Representante.',
            'id_representante.required_if' => 'Estimado usuario, seleccione un Representante..',
            'iglesia_id.required' => 'Estimado usuario, ingrese la iglesia a la cual pertenece.',
            'iglesia_id.numeric' => 'Estimado usuario, el valor del campo Iglesia es incorrecto.',
            'rango_id.numeric' => 'Estimado usuario, el valor del campo Rango es incorrecto.',
            'estado_civil_id.numeric' => 'Estimado usuario, el valor del campo Estado Civil es incorrecto.',
            'estado_id.required' => 'Estimado usuario, ingrese el Estado en el cual reside.',
            'estado_id.numeric' => 'Estimado usuario, el valor del campo Estado es incorrecto.',
            'municipio_id.required' => 'Estimado usuario, ingrese el Municipio en el cual reside.',
            'municipio_id.numeric' => 'Estimado usuario, el valor del campo Municipio es incorrecto.',
            'parroquia_id.required' => 'Estimado usuario, ingrese la Parroquia en la cual reside.',
            'parroquia_id.numeric' => 'Estimado usuario, el valor del campo Parroquia es incorrecto.',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $miembro->update($request->all());

        return response()->json([
            'data' => $miembro,
        ], 200);
    }

    public function destroy(Miembros $miembro)
    {
        $miembro->delete();
        return response()->json([
            'data' => $miembro,
        ], 200);
    }
}
