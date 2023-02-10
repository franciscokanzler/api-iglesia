<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(){
        $video = Video::all();
        return response()->json([
            'video' => $video,
        ], 200);
    }

    public function store(Request $request){
        /* $request->file('file')->storeAs('','video.'.$request->file('file')->extension(),'public');
        return $request->file('file'); */
        $url = Storage::put('public/videos',$request->file('file'));
        $url = substr($url,13);
        $request['url'] = $url;

        $rules = [
            'url' => 'required',
            'post_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $video = Video::create($request->all());

        return response()->json([
            'data' => $video,
        ], 200);
    }

    public function edit($id)
    {
        $video = Video::where('id',$id)->first();
        return response()->json([
            'video' => $video,
        ], 200);
    }

    public function update(Request $request, Video $video){

        $rules = [
            'url' => 'required',
            'post_id' => 'required',
        ];

        $ErrorMessages = [
            'url.required' => 'la url es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $ErrorMessages);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()
            ], 400);
        }

        $video->update($request->all());

        return response()->json([
            'video' => $video,
        ], 200);

    }
}
