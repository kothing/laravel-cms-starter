<?php

namespace Costar\LaravelFileManager\Controllers;

use Costar\LaravelFileManager\FileManager;
use Costar\LaravelFileManager\FileManagerPath;

class FileManagerController extends Controller
{
    protected static $success_response = 'OK';

    public function __construct()
    {
        $this->applyIniOverrides();
    }

    /**
     * Set up needed functions.
     *
     * @return object|null
     */
    public function __get($var_name)
    {
        if ($var_name === 'fileManager') {
            return app(FileManagerPath::class);
        } elseif ($var_name === 'helper') {
            return app(FileManager::class);
        }
    }

    /**
     * Show the filemanager.
     *
     * @return mixed
     */
    public function show()
    {
        return view('laravel-file-manager::index')
            ->withHelper($this->helper);
    }

    /**
     * Check if any extension or config is missing.
     *
     * @return array
     */
    public function getErrors()
    {
        $arr_errors = [];

        if (! extension_loaded('gd') && ! extension_loaded('imagick')) {
            array_push($arr_errors, trans('laravel-file-manager::fileManager.message-extension_not_found'));
        }

        if (! extension_loaded('exif')) {
            array_push($arr_errors, 'EXIF extension not found.');
        }

        if (! extension_loaded('fileinfo')) {
            array_push($arr_errors, 'Fileinfo extension not found.');
        }

        $mine_config_key = 'fileManager.folder_categories.'
            . $this->helper->currentFileManagerType()
            . '.valid_mime';

        if (! is_array(config($mine_config_key))) {
            array_push($arr_errors, 'Config : ' . $mine_config_key . ' is not a valid array.');
        }

        return $arr_errors;
    }

    /**
     * Overrides settings in php.ini.
     *
     * @return null
     */
    public function applyIniOverrides()
    {
        $overrides = config('fileManager.php_ini_overrides', []);

        if ($overrides && is_array($overrides) && count($overrides) === 0) {
            return;
        }

        foreach ($overrides as $key => $value) {
            if ($value && $value != 'false') {
                ini_set($key, $value);
            }
        }
    }
}
