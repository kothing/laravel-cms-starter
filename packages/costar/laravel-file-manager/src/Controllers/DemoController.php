<?php

namespace Costar\LaravelFileManager\Controllers;

class DemoController extends FileManagerController
{
    public function index()
    {
        return view('laravel-file-manager::demo');
    }
}
