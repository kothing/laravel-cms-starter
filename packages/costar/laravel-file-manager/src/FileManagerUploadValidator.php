<?php

namespace Costar\LaravelFileManager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Costar\LaravelFileManager\Exceptions\DuplicateFileNameException;
use Costar\LaravelFileManager\Exceptions\EmptyFileException;
use Costar\LaravelFileManager\Exceptions\ExcutableFileException;
use Costar\LaravelFileManager\Exceptions\FileFailedToUploadException;
use Costar\LaravelFileManager\Exceptions\FileSizeExceedConfigurationMaximumException;
use Costar\LaravelFileManager\Exceptions\FileSizeExceedIniMaximumException;
use Costar\LaravelFileManager\Exceptions\InvalidMimeTypeException;
use Costar\LaravelFileManager\FileManagerPath;

class FileManagerUploadValidator
{
    private $file;

    public function __construct(UploadedFile $file)
    {
        // if (! $file instanceof UploadedFile) {
        //     throw new \Exception(trans(self::PACKAGE_NAME . '::fileManager.error-instance'));
        // }

        $this->file = $file;
    }

    // public function hasContent()
    // {
    //     if (empty($this->file)) {
    //         throw new EmptyFileException();
    //     }

    //     return $this;
    // }

    public function sizeLowerThanIniMaximum()
    {
        if ($this->file->getError() == UPLOAD_ERR_INI_SIZE) {
            throw new FileSizeExceedIniMaximumException();
        }

        return $this;
    }

    public function uploadWasSuccessful()
    {
        if ($this->file->getError() != UPLOAD_ERR_OK) {
            throw new FileFailedToUploadException($this->file->getError());
        }

        return $this;
    }

    public function nameIsNotDuplicate($new_file_name, FileManagerPath $fileManager_path)
    {
        if ($fileManager_path->setName($new_file_name)->exists()) {
            throw new DuplicateFileNameException();
        }

        return $this;
    }

    public function mimetypeIsNotExcutable($excutable_mimetypes)
    {
        $mimetype = $this->file->getMimeType();

        if (in_array($mimetype, $excutable_mimetypes)) {
            throw new ExcutableFileException();
        }

        return $this;
    }

    public function extensionIsNotExcutable($excutable_extensions)
    {
        $extension = $this->file->getClientOriginalExtension();

        if (in_array($extension, $excutable_extensions)) {
            throw new ExcutableFileException();
        }

        return $this;
    }

    public function mimeTypeIsValid($available_mime_types)
    {
        $mimetype = $this->file->getMimeType();

        if (false === in_array($mimetype, $available_mime_types)) {
            throw new InvalidMimeTypeException($mimetype);
        }

        return $this;
    }

    public function sizeIsLowerThanConfiguredMaximum($max_size_in_kb)
    {
        // size to kb unit is needed
        $file_size_in_kb = $this->file->getSize() / 1000;

        if ($file_size_in_kb > $max_size_in_kb) {
            throw new FileSizeExceedConfigurationMaximumException($file_size_in_kb);
        }

        return $this;
    }
}
