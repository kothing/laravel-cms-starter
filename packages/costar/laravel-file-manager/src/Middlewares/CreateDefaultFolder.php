<?php

namespace Costar\LaravelFileManager\Middlewares;

use Closure;
use Costar\LaravelFileManager\FileManager;
use Costar\LaravelFileManager\FileManagerPath;

class CreateDefaultFolder
{
    private $fileManager;
    private $helper;

    public function __construct()
    {
        $this->fileManager = app(FileManagerPath::class);
        $this->helper = app(FileManager::class);
    }

    public function handle($request, Closure $next)
    {
        $this->checkDefaultFolderExists('user');
        $this->checkDefaultFolderExists('share');

        return $next($request);
    }

    private function checkDefaultFolderExists($type = 'share')
    {
        if (! $this->helper->allowFolderType($type)) {
            return;
        }

        $this->fileManager->dir($this->helper->getRootFolder($type))->createFolder();
    }
}
