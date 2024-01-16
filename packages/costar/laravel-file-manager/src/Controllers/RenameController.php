<?php

namespace Costar\LaravelFileManager\Controllers;

use Illuminate\Support\Facades\Storage;
use Costar\LaravelFileManager\Events\FolderIsRenaming;
use Costar\LaravelFileManager\Events\FolderWasRenamed;
use Costar\LaravelFileManager\Events\FileIsRenaming;
use Costar\LaravelFileManager\Events\FileWasRenamed;
use Costar\LaravelFileManager\Events\ImageIsRenaming;
use Costar\LaravelFileManager\Events\ImageWasRenamed;

class RenameController extends FileManagerController
{
    public function getRename()
    {
        $old_name = $this->helper->input('file');
        $new_name = $this->helper->input('new_name');

        $file = $this->fileManager->setName($old_name);

        if (!Storage::disk($this->helper->config('disk'))->exists($file->path('storage'))) {
            abort(404);
        }

        $old_file = $this->fileManager->pretty($old_name);

        $is_directory = $file->isDirectory();

        if (empty($new_name)) {
            if ($is_directory) {
                return parent::error('folder-name');
            } else {
                return parent::error('file-name');
            }
        }

        if ($is_directory && config('fileManager.alphanumeric_directory') && preg_match('/[^\w-]/i', $new_name)) {
            return parent::error('folder-alnum');
        } elseif (config('fileManager.alphanumeric_filename') && preg_match('/[^.\w-]/i', $new_name)) {
            return parent::error('file-alnum');
        } elseif ($this->fileManager->setName($new_name)->exists()) {
            return parent::error('rename');
        }

        if (! $is_directory) {
            $extension = $old_file->extension();
            if ($extension) {
                $new_name = str_replace('.' . $extension, '', $new_name) . '.' . $extension;
            }
        }

        $new_path = $this->fileManager->setName($new_name)->path('absolute');

        if ($is_directory) {
            event(new FolderIsRenaming($old_file->path(), $new_path));
        } else {
            event(new FileIsRenaming($old_file->path(), $new_path));
            event(new ImageIsRenaming($old_file->path(), $new_path));
        }

        $old_path = $old_file->path();

        if ($old_file->hasThumb()) {
            $this->fileManager->setName($old_name)->thumb()
                ->move($this->fileManager->setName($new_name)->thumb());
        }

        $this->fileManager->setName($old_name)
            ->move($this->fileManager->setName($new_name));

        if ($is_directory) {
            event(new FolderWasRenamed($old_path, $new_path));
        } else {
            event(new FileWasRenamed($old_path, $new_path));
            event(new ImageWasRenamed($old_path, $new_path));
        }

        return parent::$success_response;
    }
}
