<?php

namespace Modules\Timelog\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TimelogsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Timelogs';

        // module name
        $this->module_name = 'timelogs';

        // directory path of the module
        $this->module_path = 'timelog::backend';

        // module icon
        $this->module_icon = 'fas fa-timelogs';

        // module model name, path
        $this->module_model = "Modules\Timelog\Entities\Timelog";
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

        return redirect()->route("backend.timelogs.show", $$module_name_singular->id);
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

        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = '.$user);
        $role_name = DB::select('select `name` from `roles` where `id` = '.$role_id[0]->role_id);
        if(isset($user) && !empty($user) && $role_name[0]->name == 'super admin'){
            // $$module_name = DB::select('SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id WHERE `timelogs`.deleted_at IS NULL');
            $$module_name = DB::select('SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by, users.name AS `created_by` FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id LEFT JOIN users ON users.id = timelogs.created_by WHERE `timelogs`.deleted_at IS NULL');
        }
        elseif(isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
            $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
            //$$module_name = DB::select('SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id WHERE `timelogs`.deleted_at IS NULL AND projects.project_manager = '.$emp[0]->id);
            $qry = 'SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by, users.name AS `created_by` FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id LEFT JOIN users ON users.id = timelogs.created_by WHERE `timelogs`.deleted_at IS NULL';
            $$module_name = DB::select($qry);
        }
        else{
            $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
            //$$module_name = DB::select('SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id WHERE `timelogs`.deleted_at IS NULL AND tasks.employee_id = '.$emp[0]->id);
            $$module_name = DB::select('SELECT timelogs.id, projects.name AS project_name, milestones.name AS milestone_name, employees.name AS employee_name, tasks.name AS task_name, timelogs.name, timelogs.log_date, timelogs.start_time, timelogs.end_time, timelogs.spend_hours, timelogs.break_time, timelogs.created_by, users.name AS `created_by` FROM `timelogs` LEFT JOIN projects ON projects.id = timelogs.project_id LEFT JOIN milestones ON milestones.id = timelogs.milestone_id LEFT JOIN employees ON employees.id = timelogs.employee_id LEFT JOIN tasks ON tasks.id = timelogs.task_id LEFT JOIN users ON users.id = timelogs.created_by WHERE `timelogs`.deleted_at IS NULL AND tasks.employee_id = '.$emp[0]->id);
        }

        $data = $$module_name;
        $arr = array();

        foreach ($data as $datan) {
            //  echo "<pre>"; print_r($datan); die;
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
        //                 // ->editColumn('updated_at', function ($data) {
        //                 //     $module_name = $this->module_name;

        //                 //     $diff = Carbon::now()->diffInHours($data->updated_at);

        //                 //     if ($diff < 25) {
        //                 //         return $data->updated_at->diffForHumans();
        //                 //     } else {
        //                 //         return $data->updated_at->isoFormat('llll');
        //                 //     }
        //                 // })
        //                 ->rawColumns(['name', 'action'])
        //                 ->orderColumns(['id'], '-:column $1')
        //                 ->make(true);
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
            return response()->json([]);
        }

        $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('slug', 'LIKE', "%$term%")->get();

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id'   => $row->id,
                'text' => $row->name,
            ];
        }

        return response()->json($$module_name);
    }

    public function fetch_dropdown_value(Request $request){
        $timelog_id = $request->timelog_id;
        $qry = 'select tl.`project_id`, p.`name` AS "proname", t.`milestone_id`, m.`name` AS "milename", t.name AS "taskname", tl.task_id from `timelogs` AS tl JOIN `projects` AS p ON p.id = tl.project_id JOIN `milestones` AS m ON m.id = tl.milestone_id JOIN `tasks` AS t ON t.id = tl.task_id WHERE tl.id = '.$timelog_id;
        // echo $qry;
        $res = DB::select($qry);
        //print_r($dept);
        if($res){
            $results = json_encode($res[0]);
            return $results;
            exit;
        }
        else{
            return false;
            exit;
        }
    }
}
