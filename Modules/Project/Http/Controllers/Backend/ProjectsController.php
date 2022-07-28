<?php

namespace Modules\Project\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Projects';

        // module name
        $this->module_name = 'projects';

        // directory path of the module
        $this->module_path = 'project::backend';

        // module icon
        $this->module_icon = 'fas fa-projects';

        // module model name, path
        $this->module_model = "Modules\Project\Entities\Project";
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
            'name' => 'required|max:191|unique:' . $module_model . ',name',
            'slug' => 'nullable|max:191|unique:' . $module_model . ',slug',
        ]);

        $$module_name_singular = $module_model::create($request->except('image'));

        // if ($request->image) {
        //     $media = $$module_name_singular->addMedia($request->file('image'))->toMediaCollection($module_name);
        //     $$module_name_singular->image = $media->getUrl();
        //     $$module_name_singular->save();
        // }

        // if ($request->departments_id)
        // {
        //     $dept = DB::select('SELECT `departments.name` FROM `departments`');
        // }

        flash(icon() . ' ' . Str::singular($module_title) . "' Created.")->success()->important();

        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

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

        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

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
            'name' => 'required|max:191|unique:' . $module_model . ',name,' . $id,
            'slug' => 'nullable|max:191|unique:' . $module_model . ',slug,' . $id,
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

        flash(icon() . ' ' . Str::singular($module_title) . "' Updated Successfully")->success()->important();

        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

        return redirect()->route("backend.projects.show", $$module_name_singular->id);
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
        $query_data = array();
        $pro_id_str = '';
        if (empty($term)) {
            $user = Auth::id();
            $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = ' . $user);
            $role_name = DB::select('select `name` from `roles` where `id` = ' . $role_id[0]->role_id);
            if (isset($user) && !empty($user) && $role_name[0]->name == 'super admin') {
                $query_data = $module_model::select()->get();
            } elseif (isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
                $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
                $query_data = DB::select('select * from `projects` where deleted_at IS NUll AND `project_manager` = ' . $emp[0]->id);
            } else {
                $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
                $projectassign = DB::select('select `project_id` from `projectassigns` where `employee_id` = ' . $emp[0]->id);

                $pro_id_str = "(";
                foreach ($projectassign as $key => $value) {
                    $pro_id_str .= "'" . $value->project_id . "',";
                }
                $cnt = strlen($pro_id_str);
                $pro_emp_ids = substr($pro_id_str, 0, ($cnt - 1)) . ")";
                $query_data = DB::select('select * from `projects` where `id` IN ' . $pro_emp_ids .' AND `status`= 1');
            }
        } else {
            $user = Auth::id();
            $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = ' . $user);
            $role_name = DB::select('select `name` from `roles` where `id` = ' . $role_id[0]->role_id);
            if (isset($user) && !empty($user) && $role_name[0]->name == 'super admin') {
                //$query_data = $module_model::WhereIn('department_id', '=', $term)->get();
                $query_data = DB::select('select * from `projects` where `departments_id` = ' . $term);
            } elseif (isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
                $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
                $query_data = DB::select('select * from `projects` where `departments_id` = ' . $term . ' AND `project_manager` = ' . $emp[0]->id);
            }
            //$query_data = $module_model::whereIn('employee_id', '=', $user)->andWhere('departments_id', '=', $term)->get();
            else {
                $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
                $projectassign = DB::select('select `project_id` from `projectassigns` where `employee_id` = ' . $emp[0]->id);

                $pro_id_str = "(";
                foreach ($projectassign as $key => $value) {
                    $pro_id_str .= "'" . $value->project_id . "',";
                }
                $cnt = strlen($pro_id_str);
                $pro_emp_ids = substr($pro_id_str, 0, ($cnt - 1)) . ")";
                $query_data = DB::select('select * from `projects` where `departments_id` = ' . $term . ' AND `id` IN ' . $pro_emp_ids .' AND `status`= 1');
                //$query_data = $module_model::select()->get();
            }
            //$query_data = $module_model::where('departments_id', '=', $term)->get();
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
        $title = $page_heading . ' ' . label_case($module_action);

        // $$module_name = DB::select('SELECT projects.id, projects.name, projecttypes.name As project_type,departments.name AS department_name, projects.priority, projects.start_date, projects.end_date, projects.estimated_hours, employees.name AS employee_name,
        // COUNT(milestones.id) AS total_milestone, COUNT(tasks.milestone_id) AS total_task
        // FROM `projects` 
        // LEFT JOIN departments ON projects.departments_id = departments.id
        // LEFT JOIN projecttypes ON projects.project_type = projecttypes.id
        // LEFT JOIN employees ON projects.employees = employees.id
        // LEFT JOIN milestones
        // ON projects.id = milestones.id
        // LEFT JOIN tasks
        // ON milestones.id = tasks.milestone_id
        // GROUP BY projects.id, milestones.id');


        // $$module_name = DB::select('SELECT `p`.id, `pt`.`name` AS `project_type`, `p`.`name`,
        // `p`.`priority`,`p`.`start_date`, `p`.`end_date`, `p`.`estimated_hours`,
        //  `d`.`name` AS `department_name`, count(`m`.`id`) AS total_milestone
        // FROM `projects` AS `p` 
        // LEFT JOIN `milestones` AS `m` ON `p`.`id` =`m`.`project_id`
        // LEFT JOIN `departments` AS `d` ON `d`.`id` =`p`.`departments_id`
        // LEFT JOIN  `projecttypes` AS `pt` ON `pt`.`id` =`p`.`project_type`
        // WHERE `p`.deleted_at IS NULL GROUP BY `p`.`id`');

        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = ' . $user);
        $role_name = DB::select('select `name` from `roles` where `id` = ' . $role_id[0]->role_id);
        if (isset($user) && !empty($user) && $role_name[0]->name == 'super admin') {
            $$module_name = DB::select('SELECT `p`.id, `pt`.`name` AS `project_type`, `p`.`name`,
            `p`.`priority`,`p`.`start_date`, `p`.`end_date`, `p`.`estimated_hours`,
            `d`.`name` AS `department_name`, count(`m`.`id`) AS total_milestone
            FROM `projects` AS `p` 
            LEFT JOIN `milestones` AS `m` ON `p`.`id` =`m`.`project_id`
            LEFT JOIN `departments` AS `d` ON `d`.`id` =`p`.`departments_id`
            LEFT JOIN  `projecttypes` AS `pt` ON `pt`.`id` =`p`.`project_type`
            WHERE `p`.deleted_at IS NULL GROUP BY `p`.`id`');
        } elseif (isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
            $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
            $$module_name = DB::select('SELECT `p`.id, `pt`.`name` AS `project_type`, `p`.`name`,
            `p`.`priority`,`p`.`start_date`, `p`.`end_date`, `p`.`estimated_hours`,
            `d`.`name` AS `department_name`, count(`m`.`id`) AS total_milestone
            FROM `projects` AS `p` 
            LEFT JOIN `milestones` AS `m` ON `p`.`id` =`m`.`project_id`
            LEFT JOIN `departments` AS `d` ON `d`.`id` =`p`.`departments_id`
            LEFT JOIN  `projecttypes` AS `pt` ON `pt`.`id` =`p`.`project_type`
            WHERE `p`.deleted_at IS NULL AND `p`.project_manager = ' . $emp[0]->id . ' GROUP BY `p`.`id`');
        } else {
            $emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
            $projectassign = DB::select('select `project_id` from `projectassigns` where `employee_id` = ' . $emp[0]->id);

            $pro_id_str = "(";
            foreach ($projectassign as $key => $value) {
                $pro_id_str .= "'" . $value->project_id . "',";
            }
            $cnt = strlen($pro_id_str);
            $pro_emp_ids = substr($pro_id_str, 0, ($cnt - 1)) . ")";

            $$module_name = DB::select('SELECT `p`.id, `pt`.`name` AS `project_type`, `p`.`name`,
            `p`.`priority`,`p`.`start_date`, `p`.`end_date`, `p`.`estimated_hours`,
            `d`.`name` AS `department_name`, count(`m`.`id`) AS total_milestone
            FROM `projects` AS `p` 
            LEFT JOIN `milestones` AS `m` ON `p`.`id` =`m`.`project_id`
            LEFT JOIN `departments` AS `d` ON `d`.`id` =`p`.`departments_id`
            LEFT JOIN  `projecttypes` AS `pt` ON `pt`.`id` =`p`.`project_type`
            WHERE `p`.deleted_at IS NULL AND `p`.id IN ' . $pro_emp_ids . ' AND `p`.status=1  GROUP BY `p`.`id`');
        }
        // print_r($$module_name);
        // die();
        $data = $$module_name;
        $arr = array();
        foreach ($data as $datan) {
            $$module_name = DB::select('SELECT count(`id`) 
        AS total_task FROM `tasks` WHERE project_id=' . $datan->id . ' ');
            $total_task = $$module_name[0]->total_task;
            $datan->total_task = $total_task;
            $$module_name = DB::select('SELECT count(employee_id) AS total_employee FROM `projectassigns` WHERE project_id=' . $datan->id . ' AND deleted_at IS NULL');
            $total_employee = $$module_name[0]->total_employee;
            $datan->total_employee = $total_employee;
            // echo  $total_employee;
            // die();

            $qry_spendhrs = 'SELECT t.spend_hours AS "spend_hours" 
                            FROM `projects` AS p 
                            JOIN `timelogs` AS t 
                            ON p.id = t.project_id
                            WHERE p.id = ' . $datan->id . ' AND p.deleted_at IS NULL';
            $spend_hrs_res = DB::select($qry_spendhrs);
            $hrs_arr = array();
            for ($i = 0; $i < count($spend_hrs_res); $i++) {
                $hrs_arr[] = $spend_hrs_res[$i]->spend_hours;
            }
            $total = 0;
            foreach ($hrs_arr as $element) :
                $temp = explode(":", $element);
                $total += (int) $temp[0] * 3600;
                $total += (int) $temp[1] * 60;
                $total += (int) $temp[2];
            endforeach;
            $formatted = sprintf(
                '%02d:%02d:%02d',
                ($total / 3600),
                ($total / 60 % 60),
                $total % 60
            );
            $datan->spend_hours = $formatted;
            $arr[] = $datan;
        }
        echo json_encode(array($arr));

        // return Datatables::of($$module_name)
        //                 ->addColumn('action', function ($data) {
        //                     $module_name = $this->module_name;

        //                     return view('backend.includes.action_column', compact('module_name', 'data'));
        //                 })
        //                 ->editColumn('name', '<strong>{{ $name }}</strong>')
        //                 ->editColumn('updated_at', function ($data) {
        //                     $module_name = $this->module_name;

        //                     $diff = Carbon::now()->diffInHours($data->updated_at);

        //                     if ($diff < 25) {
        //                         return $data->updated_at->diffForHumans();
        //                     } else {
        //                         return $data->updated_at->isoFormat('llll');
        //                     }
        //                 })
        //                 ->editColumn('project_type', function ($data) {
        //                     //var_dump($data->project_type);
        //                     $projecttypes = \DB::select('SELECT name from projecttypes WHERE id = ?', [$data->project_type]);
        //                     //var_dump($projecttypes);
        //                     if(isset($projecttypes) && !empty($projecttypes)){
        //                         $data->project_type = $projecttypes[0]->name;
        //                     }
        //                     return $data->project_type;
        //                 })
        //                 ->editColumn('priority', function ($data) {
        //                     if(isset($data->priority) && !empty($data->priority) && $data->priority == '1'){
        //                         $data->priority = 'High';
        //                     }
        //                     elseif(isset($data->priority) && !empty($data->priority) && $data->priority == '2'){
        //                         $data->priority = 'Medium';
        //                     }
        //                     elseif(isset($data->priority) && !empty($data->priority) && $data->priority == '3'){
        //                         $data->priority = 'Low';
        //                     }
        //                     return $data->priority;
        //                 })
        //                 ->editColumn('departments_id', function ($data) {
        //                     //var_dump($data->departments_id);
        //                     $departments = \DB::select('SELECT name from departments WHERE id = ?', [$data->departments_id]);
        //                     //var_dump($departments);
        //                     if(isset($departments) && !empty($departments)){
        //                         $data->departments_id = $departments[0]->name;
        //                     }
        //                     return $data->departments_id;
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

    public function get_dept_pro_manager(Request $request)
    {
        $project_id = $request->project_id;
        $qry_dept = 'select p.`departments_id` , d.`name` AS "deptname", p.`project_manager`, e.`name` AS "empname", pt.name AS "projecttypename", p.project_type from `projects` AS p JOIN `departments` AS d ON p.departments_id = d.id JOIN `employees` AS e ON e.id = p.project_manager JOIN `projecttypes` AS pt ON pt.id = p.project_type WHERE p.id = ' . $project_id;
        $dept = DB::select($qry_dept);
        //print_r($dept);
        if ($dept) {
            $departments = json_encode($dept[0]);
            return $departments;
            exit;
        } else {
            return false;
            exit;
        }
    }
}
