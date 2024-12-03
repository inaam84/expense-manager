<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Plank\Mediable\Media;

class DownloadFileController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }

    public function downloadMedia($mediaIdEncrypted)
    {
        $media = Media::find(decrypt($mediaIdEncrypted));

        return response()->streamDownload(
            function () use ($media) {
                $stream = $media->stream();
                while ($bytes = $stream->read(1024)) {
                    echo $bytes;
                }
            },
            $media->basename,
            [
                'Content-Type' => $media->mime_type,
                'Content-Length' => $media->size,
            ]
        );
    }
}
