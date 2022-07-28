<?php

namespace Modules\Projecttype\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProjecttypesController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Projecttypes';

        // module name
        $this->module_name = 'projecttypes';

        // directory path of the module
        $this->module_path = 'projecttypes';

        // module icon
        $this->module_icon = 'fas fa-projecttypes';

        // module model name, path
        $this->module_model = "Modules\Projecttype\Entities\Projecttype";
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
            "projecttype::frontend.$module_path.index",
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
        $posts = $$module_name_singular->posts()->with('category', 'projecttypes', 'comments')->paginate();

        return view(
            "projecttype::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'posts')
        );
    }
}
