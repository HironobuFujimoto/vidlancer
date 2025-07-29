<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoToHLS;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('video');
        $path = $file->store('videos');


        $video = new Video();
        $video->user_id = $request->get('jwt_user');
        $video->title = $request->input('title');
        $video->file_path = $path;
        $video->save();

        // 変換ジョブをディスパッチ
        ConvertVideoToHLS::dispatch($video);

        return response()->json(['message' => 'アップロード完了、変換中です']);
    }

    public function index(Request $request)
    {
        $user_id = $request->get('jwt_user');
        $videos = Video::where('user_id', $user_id)->get();

        return response()->json([
            'data' => $videos
        ]);
    }

    public function show(Request $request, $id)
    {
        $user_id = $request->get('jwt_user');
        $video = Video::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        return response()->json([
            'id' => $video->id,
            'title' => $video->title,
            'description' => $video->description,
            'stream_url' => $video->hls_path ? asset($video->hls_path) : null
        ]);
    }
}
