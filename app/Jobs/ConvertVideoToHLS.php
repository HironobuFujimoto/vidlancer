<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use FFMpeg;

class ConvertVideoToHLS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inputPath = storage_path('app/' . $this->video->path);
        $outputDir = storage_path('app/public/hls/' . $this->video->id);
        $playlistPath = $outputDir . '/index.m3u8';

        // ディレクトリ作成
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // HLS変換コマンド (要ffmpeg)
        $cmd = "ffmpeg -i $inputPath -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $playlistPath";
        exec($cmd);

        // 変換後のパスを保存（任意）
        $this->video->hls_path = 'storage/hls/' . $this->video->id . '/index.m3u8';
        $this->video->save();
    }
}
