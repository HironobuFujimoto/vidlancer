<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoStreamController extends Controller
{
    public function show(Request $request, $id)
    {
        $user_id = $request->get('jwt_user');

        // ユーザー自身の動画か確認
        $video = Video::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        // hls_pathが未設定の場合
        if (!$video->hls_path) {
            return response()->json(['error' => 'HLS not available yet'], 404);
        }

        // 実ファイルが存在するかチェック
        if (!file_exists(public_path($video->hls_path))) {
            return response()->json(['error' => 'Stream file not found'], 404);
        }

        // 公開URLを返す
        $streamUrl = asset($video->hls_path);
        return response()->json([
            'stream_url' => $streamUrl
        ]);
    }
}
