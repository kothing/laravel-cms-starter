<?php

namespace Costar\LaravelFileManager;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerItem
{
    private $fileManager;
    private $helper;
    private $isDirectory;
    private $mimeType = null;

    private $columns = [];
    public $attributes = [];

    public function __construct(FileManagerPath $fileManager, FileManager $helper, $isDirectory = false)
    {
        $this->fileManager = $fileManager->thumb(false);
        $this->helper = $helper;
        $this->isDirectory = $isDirectory;
        $this->columns = $helper->config('item_columns') ?:
            ['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url'];
    }

    public function __get($var_name)
    {
        if (!array_key_exists($var_name, $this->attributes)) {
            $function_name = Str::camel($var_name);
            $this->attributes[$var_name] = $this->$function_name();
        }

        return $this->attributes[$var_name];
    }

    public function fill()
    {
        foreach ($this->columns as $column) {
            $this->__get($column);
        }

        return $this;
    }

    public function name()
    {
        return $this->fileManager->getName();
    }

    public function path($type = 'absolute')
    {
        return $this->fileManager->path($type);
    }

    public function isDirectory()
    {
        return $this->isDirectory;
    }

    public function isFile()
    {
        return ! $this->isDirectory();
    }

    /**
     * Check a file is image or not.
     *
     * @param  mixed  $file  Real path of a file or instance of UploadedFile.
     * @return bool
     */
    public function isImage()
    {
        return $this->isFile() && Str::startsWith($this->mimeType(), 'image');
    }

    /**
     * Get mime type of a file.
     *
     * @param  mixed  $file  Real path of a file or instance of UploadedFile.
     * @return string
     */
    public function mimeType()
    {
        if (is_null($this->mimeType)) {
            $this->mimeType = $this->fileManager->mimeType();
        }

        return $this->mimeType;
    }

    public function extension()
    {
        return $this->fileManager->extension();
    }

    public function url()
    {
        if ($this->isDirectory()) {
            return $this->fileManager->path('working_dir');
        }

        return $this->fileManager->url();
    }

    public function size()
    {
        return $this->isFile() ? $this->humanFilesize($this->fileManager->size()) : '';
    }

    public function time()
    {
        return $this->fileManager->lastModified();
    }

    public function thumbUrl()
    {
        if ($this->isDirectory()) {
            return asset('vendor/' . FileManager::PACKAGE_NAME . '/img/folder.png');
        }

        if ($this->isImage()) {
            return $this->fileManager->thumb($this->hasThumb())->url(true);
        }

        return null;
    }

    public function icon()
    {
        if ($this->isDirectory()) {
            return 'fa-folder-o';
        }

        if ($this->isImage()) {
            return 'fa-image';
        }

        return $this->extension();
    }

    public function type()
    {
        if ($this->isDirectory()) {
            return trans(FileManager::PACKAGE_NAME . '::fileManager.type-folder');
        }

        if ($this->isImage()) {
            return $this->mimeType();
        }

        return $this->helper->getFileType($this->extension());
    }

    public function hasThumb()
    {
        if (!$this->isImage()) {
            return false;
        }

        if (!$this->fileManager->thumb()->exists()) {
            return false;
        }

        return true;
    }

    public function shouldCreateThumb()
    {
        if (!$this->helper->config('should_create_thumbnails')) {
            return false;
        }

        if (!$this->isImage()) {
            return false;
        }

        if (in_array($this->mimeType(), ['image/gif', 'image/svg+xml'])) {
            return false;
        }

        return true;
    }

    public function get()
    {
        return $this->fileManager->get();
    }

    /**
     * Make file size readable.
     *
     * @param  int  $bytes     File size in bytes.
     * @param  int  $decimals  Decimals.
     * @return string
     */
    public function humanFilesize($bytes, $decimals = 2)
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), @$size[$factor]);
    }
}
