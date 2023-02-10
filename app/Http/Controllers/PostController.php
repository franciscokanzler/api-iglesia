<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\Imagen;
use App\Models\Video;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return response()->json([
            'posts' => $posts,
        ], 200);
    }

    public function store(Request $request){
        if ($request->actividades) {
            $rules = [
                'nombre' => 'required',
                'lugar' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_culminacion' => 'required|date',
                'hora_inicio' => 'required',
                'hora_culminacion' => 'required',
                'estatus_id' => 'required',
                'categoria_id' => 'required',
            ];

            $ErrorMessages = [
                'nombre.required' => 'El nombre de la actividad es requerido ',
            ];

            foreach ($request->actividades as $value) {
                $validator = Validator::make($value, $rules, $ErrorMessages);
                if ($validator->fails()) {
                    return response()->json([
                        'created' => false,
                        'errors'  => $validator->errors()
                    ], 400);
                }
            }
        }

        $rules = [
            'user_id' => 'required',
        ];

        $ErrorMessages = [
            'user_id.required' => 'El id del usuario es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $posts = Post::create($request->all());

        if ($request->file()) {
            $archivos = $request->file();
            foreach ($archivos as $value) {
                if ($value->extension()=='png'||$value->extension()=='jpg'||$value->extension()=='jpeg') {
                    $url = Storage::put('public/imagen',$value);
                    $url = substr($url,14);
                    $posts->image()->create([
                        'url' => $url,
                    ]);
                }else if ($value->extension()=='mp4'){
                    $url = Storage::put('public/video',$value);
                    $url = substr($url,13);
                    $posts->video()->create([
                        'url' => $url,
                        'post_id' => $posts->id
                    ]);
                }
            }
        }

        if ($request->actividades) {
            foreach ($request->actividades as $value) {
                $posts->actividades()->create([
                    'nombre' => $value['nombre'],
                    'lugar' => $value['lugar'],
                    'fecha_inicio' => $value['fecha_inicio'],
                    'fecha_culminacion' => $value['fecha_culminacion'],
                    'hora_inicio' => $value['hora_inicio'],
                    'hora_culminacion' => $value['hora_culminacion'],
                    'post_id' => $posts->id,
                    'estatus_id' => $value['estatus_id'],
                    'categoria_id' => $value['categoria_id']
                ]);
            }
        }

        return response()->json([
            'data' => $posts,
        ], 200);
    }

    public function edit($id)
    {
        $posts = Post::where('id',$id)->first();
        $imagen = $posts->image()->where('imageable_id',$id)->get();
        $video = Video::where('post_id',$id)->get();
        $actividades = $posts->actividades()->where('post_id',$id)->get();
        return response()->json([
            'posts' => $posts,
            'imagen' => $imagen,
            'video' => $video,
            'actividades' => $actividades
        ], 200);
    }

    public function update(Request $request, $id){
        if ($request->actividades) {
            $rules = [
                'id' => 'required',
                'nombre' => 'required',
                'lugar' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_culminacion' => 'required|date',
                'hora_inicio' => 'required',
                'hora_culminacion' => 'required',
                'estatus_id' => 'required',
                'categoria_id' => 'required',
            ];

            $ErrorMessages = [
                'nombre.required' => 'El nombre de la actividad es requerido ',
            ];

            foreach ($request->actividades as $value) {
                $validator = Validator::make($value, $rules, $ErrorMessages);
                if ($validator->fails()) {
                    return response()->json([
                        'created' => false,
                        'errors'  => $validator->errors()
                    ], 400);
                }
            }
        }

        $rules = [
            'user_id' => 'required',
        ];

        $ErrorMessages = [
            'user_id.required' => 'El id del usuario es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $posts = Post::where('id',$id)->first();
        $posts->update($request->all());

        if ($request->file()) {
            $archivos = $request->file();
            foreach ($archivos as $value) {
                if ($value->extension()=='png'||$value->extension()=='jpg'||$value->extension()=='jpeg') {
                    $imagen = Imagen::where('imageable_id',$id)->where('imageable_type','App\Models\Post')->where('url',$value->getClientOriginalName())->first();
                    if(!$imagen){
                        $url = Storage::put('public/imagen',$value);
                        $url = substr($url,14);
                        $posts->image()->create([
                            'url' => $url,
                        ]);
                    }

                }else if ($value->extension()=='mp4'){
                    $video = Video::where('post_id',$id)->where('url',$value->getClientOriginalName())->first();
                    if(!$video){
                        $url = Storage::put('public/video',$value);
                        $url = substr($url,13);
                        $posts->video()->create([
                            'url' => $url,
                            'post_id' => $posts->id
                        ]);
                    }
                }
            }
        }

        if ($request->actividades) {
            foreach ($request->actividades as $value) {
                $actividad = Actividades::where('id',$value['id'])->first();
                if ($actividad) {
                    $actividad->update([
                        'nombre' => $value['nombre'],
                        'lugar' => $value['lugar'],
                        'fecha_inicio' => $value['fecha_inicio'],
                        'fecha_culminacion' => $value['fecha_culminacion'],
                        'hora_inicio' => $value['hora_inicio'],
                        'hora_culminacion' => $value['hora_culminacion'],
                        'post_id' => $value['post_id'],
                        'estatus_id' => $value['estatus_id'],
                        'categoria_id' => $value['categoria_id']
                    ]);
                }
            }
        }

        return response()->json([
            'posts' => $posts,
        ], 200);

    }

    public function destroy($id){
        $post = Post::where('id',$id);
        $imagen = Imagen::where('imageable_id',$id)->where('imageable_type','App\Models\Post')->get();
        if ($imagen) {
            foreach ($imagen as $value) {
                if(Storage::exists('public/imagen/'.$value->url)){
                    Storage::delete('public/imagen/'.$value->url);
                    $value->delete();
                }
            }
        }
        $video = Video::where('post_id',$id)->get();
        if ($video) {
            foreach ($video as $value) {
                Storage::delete('public/video/'.$value->url);
                $value->delete();
            }
        }
        $post->delete();
        return response()->json([
            'delete' => true,
        ], 200);
    }

    public function destroy_imagen_post($id){
        $imagen = Imagen::where('id',$id)->where('imageable_type','App\Models\Post')->first();
        if ($imagen) {
            foreach ($imagen as $value) {
                if(Storage::exists('public/imagen/'.$value->url)){
                    Storage::delete('public/imagen/'.$value->url);
                    $value->delete();
                }
            }
        }

        return response()->json([
            'delete' => true,
        ], 200);
    }

    public function destroy_video_post($id){
        $video = Video::where('id',$id)->first();
        if ($video) {
            foreach ($video as $value) {
                if(Storage::exists('public/video/'.$value->url)){
                    Storage::delete('public/video/'.$value->url);
                    $value->delete();
                }
            }
        }

        return response()->json([
            'delete' => true,
        ], 200);
    }

    public function destroy_actividad_post($id){
        $actividad = Actividades::where('id',$id)->first();
        if ($actividad) {
            $actividad->delete();
        }

        return response()->json([
            'delete' => true,
        ], 200);
    }
}
