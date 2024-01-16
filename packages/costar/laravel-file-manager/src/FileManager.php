<?php

namespace Costar\LaravelFileManager;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Costar\LaravelFileManager\Middlewares\CreateDefaultFolder;
use Costar\LaravelFileManager\Middlewares\MultiUser;

class FileManager
{
    const PACKAGE_NAME = 'laravel-file-manager';
    const DS = '/';

    protected $config;
    protected $request;

    public function __construct(Config $config = null, Request $request = null)
    {
        $this->config = $config;
        $this->request = $request;
    }

    public function getStorage($storage_path)
    {
        return new FileManagerStorageRepository($storage_path, $this);
    }

    public function input($key)
    {
        return $this->translateFromUtf8($this->request->input($key));
    }

    public function config($key)
    {
        return $this->config->get('fileManager.' . $key);
    }

    /**
     * Get only the file name.
     *
     * @param  string  $path  Real path of a file.
     * @return string
     */
    public function getNameFromPath($path)
    {
        return $this->utf8Pathinfo($path, 'basename');
    }

    public function utf8Pathinfo($path, $part_name)
    {
        // XXX: all locale work-around for issue: utf8 file name got emptified
        // if there's no '/', we're probably dealing with just a filename
        // so just put an 'a' in front of it
        if (strpos($path, '/') === false) {
            $path_parts = pathinfo('a' . $path);
        } else {
            $path = str_replace('/', '/a', $path);
            $path_parts = pathinfo($path);
        }

        return substr($path_parts[$part_name], 1);
    }

    public function allowFolderType($type)
    {
        if ($type == 'user') {
            return $this->allowMultiUser();
        } else {
            return $this->allowShareFolder();
        }
    }

    public function getCategoryName()
    {
        $type = $this->currentFileManagerType();

        return $this->config->get('fileManager.folder_categories.' . $type . '.folder_name', 'files');
    }

    /**
     * Get current fileManager type.
     *
     * @return string
     */
    public function currentFileManagerType()
    {
        $fileManager_type = 'file';

        $request_type = lcfirst(Str::singular($this->input('type') ?: ''));
        $available_types = array_keys($this->config->get('fileManager.folder_categories') ?: []);

        if (in_array($request_type, $available_types)) {
            $fileManager_type = $request_type;
        }

        return $fileManager_type;
    }

    public function getDisplayMode()
    {
        $type_key = $this->currentFileManagerType();
        $startup_view = $this->config->get('fileManager.folder_categories.' . $type_key . '.startup_view');

        $view_type = 'grid';
        $target_display_type = $this->input('show_list') ?: $startup_view;

        if (in_array($target_display_type, ['list', 'grid'])) {
            $view_type = $target_display_type;
        }

        return $view_type;
    }

    public function getUserSlug()
    {
        $config = $this->config->get('fileManager.private_folder_name');

        if (is_callable($config)) {
            return call_user_func($config);
        }

        if (class_exists($config)) {
            return app()->make($config)->userField();
        }

        return empty(auth()->user()) ? '' : auth()->user()->$config;
    }

    public function getRootFolder($type = null)
    {
        if (is_null($type)) {
            $type = 'share';
            if ($this->allowFolderType('user')) {
                $type = 'user';
            }
        }

        if ($type === 'user') {
            $folder = $this->getUserSlug();
        } else {
            $folder = $this->config->get('fileManager.shared_folder_name');
        }

        // the slash is for url, dont replace it with directory seperator
        return '/' . $folder;
    }

    public function getThumbFolderName()
    {
        return $this->config->get('fileManager.thumb_folder_name');
    }

    public function getFileType($ext)
    {
        return $this->config->get("fileManager.file_type_array.{$ext}", 'File');
    }

    public function availableMimeTypes()
    {
        return $this->config->get('fileManager.folder_categories.' . $this->currentFileManagerType() . '.valid_mime');
    }
    
    public function shouldCreateCategoryThumb()
    {
        return $this->config->get('fileManager.folder_categories.' . $this->currentFileManagerType() . '.thumb');
    }

    public function categoryThumbWidth()
    {
        return $this->config->get('fileManager.folder_categories.' . $this->currentFileManagerType() . '.thumb_width');
    }

    public function categoryThumbHeight()
    {
        return $this->config->get('fileManager.folder_categories.' . $this->currentFileManagerType() . '.thumb_height');
    }

    public function maxUploadSize()
    {
        return $this->config->get('fileManager.folder_categories.' . $this->currentFileManagerType() . '.max_size');
    }

    public function getPaginationPerPage()
    {
        return $this->config->get("fileManager.paginator.perPage", 30);
    }

    /**
     * Check if users are allowed to use their private folders.
     *
     * @return bool
     */
    public function allowMultiUser()
    {
        $type_key = $this->currentFileManagerType();

        if ($this->config->has('fileManager.folder_categories.' . $type_key . '.allow_private_folder')) {
            return $this->config->get('fileManager.folder_categories.' . $type_key . '.allow_private_folder') === true;
        }

        return $this->config->get('fileManager.allow_private_folder') === true;
    }

    /**
     * Check if users are allowed to use the shared folder.
     * This can be disabled only when allowMultiUser() is true.
     *
     * @return bool
     */
    public function allowShareFolder()
    {
        if (! $this->allowMultiUser()) {
            return true;
        }

        $type_key = $this->currentFileManagerType();

        if ($this->config->has('fileManager.folder_categories.' . $type_key . '.allow_shared_folder')) {
            return $this->config->get('fileManager.folder_categories.' . $type_key . '.allow_shared_folder') === true;
        }

        return $this->config->get('fileManager.allow_shared_folder') === true;
    }

    /**
     * Translate file name to make it compatible on Windows.
     *
     * @param  string  $input  Any string.
     * @return string
     */
    public function translateFromUtf8($input)
    {
        if ($this->isRunningOnWindows()) {
            $input = iconv('UTF-8', mb_detect_encoding($input), $input);
        }

        return $input;
    }

    /**
     * Get directory seperator of current operating system.
     *
     * @return string
     */
    public function ds()
    {
        $ds = FileManager::DS;
        if ($this->isRunningOnWindows()) {
            $ds = '\\';
        }

        return $ds;
    }

    /**
     * Check current operating system is Windows or not.
     *
     * @return bool
     */
    public function isRunningOnWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Shorter function of getting localized error message..
     *
     * @param  mixed  $error_type  Key of message in lang file.
     * @param  mixed  $variables   Variables the message needs.
     * @return string
     */
    public function error($error_type, $variables = [])
    {
        throw new \Exception(trans(self::PACKAGE_NAME . '::fileManager.error-' . $error_type, $variables));
    }

    /**
     * Generates routes of this package.
     *
     * @return void
     */
    public static function routes()
    {
        $middleware = [ CreateDefaultFolder::class, MultiUser::class ];
        $as = 'costar.fileManager.';
        $namespace = '\\Costar\\LaravelFileManager\\Controllers\\';

        Route::group(compact('middleware', 'as', 'namespace'), function () {

            // display main layout
            Route::get('/', [
                'uses' => 'FileManagerController@show',
                'as' => 'show',
            ]);

            // display integration error messages
            Route::get('/errors', [
                'uses' => 'FileManagerController@getErrors',
                'as' => 'getErrors',
            ]);

            // upload
            Route::any('/upload', [
                'uses' => 'UploadController@upload',
                'as' => 'upload',
            ]);

            // list images & files
            Route::get('/jsonitems', [
                'uses' => 'ItemsController@getItems',
                'as' => 'getItems',
            ]);

            Route::get('/move', [
                'uses' => 'ItemsController@move',
                'as' => 'move',
            ]);

            Route::get('/domove', [
                'uses' => 'ItemsController@domove',
                'as' => 'domove'
            ]);

            // folders
            Route::get('/newfolder', [
                'uses' => 'FolderController@getAddfolder',
                'as' => 'getAddfolder',
            ]);

            // list folders
            Route::get('/folders', [
                'uses' => 'FolderController@getFolders',
                'as' => 'getFolders',
            ]);

            // crop
            Route::get('/crop', [
                'uses' => 'CropController@getCrop',
                'as' => 'getCrop',
            ]);
            Route::get('/cropimage', [
                'uses' => 'CropController@getCropimage',
                'as' => 'getCropimage',
            ]);
            Route::get('/cropnewimage', [
                'uses' => 'CropController@getNewCropimage',
                'as' => 'getCropnewimage',
            ]);

            // rename
            Route::get('/rename', [
                'uses' => 'RenameController@getRename',
                'as' => 'getRename',
            ]);

            // scale/resize
            Route::get('/resize', [
                'uses' => 'ResizeController@getResize',
                'as' => 'getResize',
            ]);
            Route::get('/doresize', [
                'uses' => 'ResizeController@performResize',
                'as' => 'performResize',
            ]);

            // download
            Route::get('/download', [
                'uses' => 'DownloadController@getDownload',
                'as' => 'getDownload',
            ]);

            // delete
            Route::get('/delete', [
                'uses' => 'DeleteController@getDelete',
                'as' => 'getDelete',
            ]);

            Route::get('/demo', 'DemoController@index');
        });
    }
}
