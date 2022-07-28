<?php

namespace Modules\Milestone\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MilestonesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Milestones';

        // module name
        $this->module_name = 'milestones';

        // directory path of the module
        $this->module_path = 'milestone::backend';

        // module icon
        $this->module_icon = 'fas fa-milestones';

        // module model name, path
        $this->module_model = "Modules\Milestone\Entities\Milestone";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $validatedData = $request->validate([
            'name' => 'required|max:191|unique:'.$module_model.',name',
            'slug' => 'nullable|max:191|unique:'.$module_model.',slug',
        ]);

        $$module_name_singular = $module_model::create($request->except('image'));

        if ($request->image) {
            $media = $$module_name_singular->addMedia($request->file('image'))->toMediaCollection($module_name);
            $$module_name_singular->image = $media->getUrl();
            $$module_name_singular->save();
        }

        flash(icon().' '.Str::singular($module_title)."' Created.")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect("admin/$module_name");
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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);

        $posts = $$module_name_singular->posts()->latest()->paginate();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "$module_path.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular", 'posts')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $validatedData = $request->validate([
            'name' => 'required|max:191|unique:'.$module_model.',name,'.$id,
            'slug' => 'nullable|max:191|unique:'.$module_model.',slug,'.$id,
        ]);

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->update($request->except('image', 'image_remove'));

        // Image
        if ($request->hasFile('image')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }
            $media = $$module_name_singular->addMedia($request->file('image'))->toMediaCollection($module_name);

            $$module_name_singular->image = $media->getUrl();

            $$module_name_singular->save();
        }
        if ($request->image_remove == 'image_remove') {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();

                $$module_name_singular->image = '';

                $$module_name_singular->save();
            }
        }

        flash(icon().' '.Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect()->route("backend.milestones.show", $$module_name_singular->id);
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $term = trim($request->q);

        if (empty($term)) {
        
            $query_data = $module_model::select()->get()->where('status', 1); 
            
            
        }
        else {
            $query_data = $module_model::where('project_id','=',$term)->get()->where('status', 1);
        }

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id'   => $row->id,
                'text' => $row->name,
            ];
            
        }

        return response()->json($$module_name);
    }


    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        // $$module_name = $module_model::select('id', 'name', 'slug', 'start_date', 'end_date', 'hours', 'milestone_weightage', 'project_id' ,'updated_at');
        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = '.$user);
        $role_name = DB::select('select `name` from `roles` where `id` = '.$role_id[0]->role_id);
        if(isset($user) && !empty($user) && $role_name[0]->name == 'super admin'){
            $$module_name = DB::select("SELECT milestones.id , milestones.name, milestones.start_date, milestones.end_date, milestones.hours,milestones.milestone_weightage, milestones.milestone_short_description, projects.name AS project_name, COUNT(tasks.milestone_id) AS total_task FROM milestones LEFT JOIN projects ON milestones.project_id = projects.id LEFT JOIN tasks ON milestones.id = tasks.milestone_id WHERE milestones.deleted_at IS NULL GROUP BY milestones.id ORDER BY id DESC");
        }
        elseif(isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
            $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
            $$module_name = DB::select("SELECT milestones.id , milestones.name, milestones.start_date, milestones.end_date, milestones.hours,milestones.milestone_weightage, milestones.milestone_short_description, projects.name AS project_name, COUNT(tasks.milestone_id) AS total_task FROM milestones LEFT JOIN projects ON milestones.project_id = projects.id LEFT JOIN tasks ON milestones.id = tasks.milestone_id WHERE milestones.deleted_at IS NULL AND projects.deleted_by IS NULL AND projects.project_manager = ".$emp[0]->id." GROUP BY milestones.id order by id DESC");
        }
        else{
            $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
            $projectassign = DB::select('select `project_id` from `projectassigns` where `employee_id` = '.$emp[0]->id);
            
            $pro_id_str = "(";
            foreach ($projectassign as $key => $value) {
                $pro_id_str .= "'".$value->project_id."',";
            }
            $cnt = strlen($pro_id_str);
            $pro_emp_ids = substr($pro_id_str, 0, ($cnt-1)) . ")";

            $$module_name = DB::select("SELECT milestones.id , milestones.name, milestones.start_date, milestones.end_date, milestones.hours,milestones.milestone_weightage, milestones.milestone_short_description, projects.name AS project_name, COUNT(tasks.milestone_id) AS total_task FROM milestones LEFT JOIN projects ON milestones.project_id = projects.id LEFT JOIN tasks ON milestones.id = tasks.milestone_id WHERE milestones.deleted_at IS NULL AND projects.deleted_by IS NULL AND  milestones.status= 1  AND projects.id IN ".$pro_emp_ids. "  GROUP BY milestones.id");
        }
        // $$module_name = 
        
        $data = $$module_name;
        $arr = array();

        foreach ($data as $datan) {
            /*echo $datan->name;
            echo $datan->slug;
            echo $datan->start_date;
            echo $datan->end_date;
            echo $datan->hours;
            echo $datan->milestone_weightage;
            echo $datan->milestone_short_description;
            echo $datan->updated_at;*/
            $arr[] = $datan;
        }
        echo json_encode(array($arr));

        // return Datatables::of($$module_name)
        //                 ->addColumn('action', function ($data) {
        //                     $module_name = $this->module_name;

        //                     return view('backend.includes.action_column', compact('module_name', 'data'));
        //                 })
        //                 ->editColumn('name', '<strong>{{$name}}</strong>')
        //                 ->editColumn('updated_at', function ($data) {
        //                     $module_name = $this->module_name;

        //                     $diff = Carbon::now()->diffInHours($data->updated_at);

        //                     if ($diff < 25) {
        //                         return $data->updated_at->diffForHumans();
        //                     } else {
        //                         return $data->updated_at->isoFormat('llll');
        //                     }
        //                 })
        //                 ->editColumn('project_id', function ($data) {
        //                     //var_dump($data->project_id);
        //                     $projects = \DB::select('SELECT name from projects WHERE id = ?', [$data->project_id]);
        //                     //var_dump($projects);
        //                     if(isset($projects) && !empty($projects)){
        //                         $data->project_id = $projects[0]->name;
        //                     }
        //                     return $data->project_id;
        //                 })
        //                 ->editColumn('status', function ($data) {
        //                     if(isset($data->status) && !empty($data->status) && $data->status == 1){
        //                         $data->status = 'Published';
        //                     }
        //                     elseif(isset($data->status) && $data->status == 0){
        //                         $data->status = 'Unpublished';
        //                     }
        //                     elseif(isset($data->status) && !empty($data->status) && $data->status == 2){
        //                         $data->status = 'Draft';
        //                     }
        //                     return $data->status;
        //                 })
        //                 ->editColumn('created_by', function ($data) {
        //                     //var_dump($data->milestone_id);
        //                     $user_name = \DB::select('SELECT name from users WHERE id = ?', [$data->created_by]);
        //                     //var_dump($milestone);
        //                     if(isset($user_name) && !empty($user_name)){
        //                         $data->assign_by = $user_name[0]->name;
        //                     }
        //                     return $data->assign_by;
        //                 })
        //                 ->editColumn('updated_by', function ($data) {
        //                     //var_dump($data->milestone_id);
        //                     $user_name = \DB::select('SELECT name from users WHERE id = ?', [$data->updated_by]);
        //                     //var_dump($milestone);
        //                     if(isset($user_name) && !empty($user_name)){
        //                         $data->assign_by = $user_name[0]->name;
        //                     }
        //                     return $data->assign_by;
        //                 })
        //                 ->rawColumns(['name', 'action'])
        //                 ->orderColumns(['id'], '-:column $1')
        //                 ->make(true);
    }

    public function get_project(Request $request){
        $milestone_id = $request->milestone_id;
        $qry_pro = 'select m.`project_id`, p.`name` AS "proname" from `milestones` AS m JOIN `projects` AS p ON p.id = m.project_id WHERE m.id = '.$milestone_id;

        $pro = DB::select($qry_pro);
        //print_r($dept);
        if($pro){
            $project = json_encode($pro[0]);
            return $project;
            exit;
        }
        else{
            return false;
            exit;
        }
    }
}