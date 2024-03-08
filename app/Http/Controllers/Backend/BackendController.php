<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Costar\DataTables\DataTables;

class BackendController extends Controller
{
    use Authorizable;

    public $module_title;

    public $module_path;

    public $module_model_page;
    public $module_model_post;
    public $module_model_user;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Dashboard';
        
        // module name
        $this->module_name = 'dashboard';

        // page model
        $this->module_model_page = "Modules\Page\Models\Page";
        
        // post model
        $this->module_model_post = "Modules\Article\Models\Post";
        
        // user model
        $this->module_model_user = "App\Models\User";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        
        $data = [
            "pages"     => $this->module_model_page::latest()->paginate(),
            "posts"     => $this->module_model_post::latest()->paginate(),
            "users"     => $this->module_model_user::latest()->paginate(),
        ];

        // return response()->json($data);
        return view("backend.index", $data);
    }
}
