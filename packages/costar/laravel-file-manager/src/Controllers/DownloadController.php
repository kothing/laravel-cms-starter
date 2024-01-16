<?php

namespace Costar\LaravelFileManager\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadController extends FileManagerController
{
    public function getDownload()
    {
        $file = $this->fileManager->setName(request('file'));

        if (!Storage::disk($this->helper->config('disk'))->exists($file->path('storage'))) {
            abort(404);
        }

        return response()->download($file->path('absolute'));
    }
}
