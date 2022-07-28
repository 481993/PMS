<?php

namespace Modules\Tasktype\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class TasktypesController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Tasktypes';

        // module name
        $this->module_name = 'tasktypes';

        // directory path of the module
        $this->module_path = 'tasktypes';

        // module icon
        $this->module_icon = 'fas fa-tasktypes';

        // module model name, path
        $this->module_model = "Modules\Tasktype\Entities\Tasktype";
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
            "tasktype::frontend.$module_path.index",
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
        $posts = $$module_name_singular->posts()->with('category', 'tasktypes', 'comments')->paginate();

        return view(
            "tasktype::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'posts')
        );
    }
}
