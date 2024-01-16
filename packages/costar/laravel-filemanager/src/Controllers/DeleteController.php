<?php

namespace Costar\LaravelFilemanager\Controllers;

use Illuminate\Support\Facades\Storage;
use Costar\LaravelFilemanager\Events\FileIsDeleting;
use Costar\LaravelFilemanager\Events\FileWasDeleted;
use Costar\LaravelFilemanager\Events\FolderIsDeleting;
use Costar\LaravelFilemanager\Events\FolderWasDeleted;
use Costar\LaravelFilemanager\Events\ImageIsDeleting;
use Costar\LaravelFilemanager\Events\ImageWasDeleted;

class DeleteController extends LfmController
{
    /**
     * Delete image and associated thumbnail.
     *
     * @return mixed
     */
    public function getDelete()
    {
        $item_names = request('items');
        $errors = [];

        foreach ($item_names as $name_to_delete) {
            $file = $this->lfm->setName($name_to_delete);

            if ($file->isDirectory()) {
                event(new FolderIsDeleting($file->path('absolute')));
            } else {
                event(new FileIsDeleting($file->path('absolute')));
                event(new ImageIsDeleting($file->path('absolute')));
            }

            if (!Storage::disk($this->helper->config('disk'))->exists($file->path('storage'))) {
                abort(404);
            }

            $file_to_delete = $this->lfm->pretty($name_to_delete);
            $file_path = $file_to_delete->path('absolute');

            if (is_null($name_to_delete)) {
                array_push($errors, parent::error('folder-name'));
                continue;
            }

            if (! $this->lfm->setName($name_to_delete)->exists()) {
                array_push($errors, parent::error('folder-not-found', ['folder' => $file_path]));
                continue;
            }

            if ($this->lfm->setName($name_to_delete)->isDirectory()) {
                if (! $this->lfm->setName($name_to_delete)->directoryIsEmpty()) {
                    array_push($errors, parent::error('delete-folder'));
                    continue;
                }

                $this->lfm->setName($name_to_delete)->delete();

                event(new FolderWasDeleted($file_path));
            } else {
                if ($file_to_delete->isImage()) {
                    $this->lfm->setName($name_to_delete)->thumb()->delete();
                }

                $this->lfm->setName($name_to_delete)->delete();

                event(new FileWasDeleted($file_path));
                event(new ImageWasDeleted($file_path));
            }
        }

        if (count($errors) > 0) {
            return $errors;
        }

        return parent::$success_response;
    }
}
