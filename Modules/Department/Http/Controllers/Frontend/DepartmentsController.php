<?php

namespace Modules\Department\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DepartmentsController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Departments';

        // module name
        $this->module_name = 'departments';

        // directory path of the module
        $this->module_path = 'departments';

        // module icon
        $this->module_icon = 'fas fa-departments';

        // module model name, path
        $this->module_model = "Modules\Department\Entities\Department";
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
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::latest()->with('posts')->paginate();

        return view(
            "department::frontend.$module_path.index",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);
        $posts = $$module_name_singular->posts()->with('category', 'departments', 'comments')->paginate();

        return view(
            "department::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'posts')
        );
    }
}
