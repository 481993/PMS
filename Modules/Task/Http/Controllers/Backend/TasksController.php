<?php

namespace Modules\Task\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TasksController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Tasks';

        // module name
        $this->module_name = 'tasks';

        // directory path of the module
        $this->module_path = 'task::backend';

        // module icon
        $this->module_icon = 'fas fa-tasks';

        // module model name, path
        $this->module_model = "Modules\Task\Entities\Task";
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

        return redirect()->route("backend.tasks.show", $$module_name_singular->id);
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
        
        //$$module_name = $module_model::select('id', 'name', 'milestone_id', 'task_priority', 'assign_by', 'end_date', 'status');

     // echo "hello";
    //die();
    //$$module_name = DB::select('select `status` from `tasks` where `user_id` = '.$user);
   // $task_id = $datan->id;
    // $$module_name =  DB::select('SELECT * FROM `tasks` WHERE status = 1');
    // print_r($$module_name);
    // die;
        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = '.$user);
        $role_name = DB::select('select `name` from `roles` where `id` = '.$role_id[0]->role_id);
        $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
      //$status = DB::select('SELECT * FROM `tasks` Where `status` = 0');

        // print_r($status);
        // die;
        
        if(isset($user) && !empty($user) && $role_name[0]->name == 'super admin'){
           
            $$module_name = DB::select('SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( timelogs.`spend_hours`)))  AS spend_hours, tasks.`id`, tasks.`name` AS task_name, tasks.`task_priority`,
             users.name AS assign_by, tasks.`end_date`, tasks.`task_status`, milestones.`name` AS milestone_name,employees.`name` AS assign_to,projects.`name` AS project_name
              FROM `tasks` INNER JOIN `milestones` ON milestones.id = tasks.milestone_id 
              LEFT JOIN `users` ON tasks.assign_by = users.id
              LEFT JOIN `employees` ON employees.id = tasks.employee_id
              LEFT JOIN `projects` ON projects.id = tasks.project_id  
              LEFT JOIN `timelogs` ON timelogs.task_id = tasks.id
              WHERE tasks.deleted_at IS NULL AND milestones.deleted_at IS NULL AND projects.deleted_at IS NULL GROUP BY id ORDER BY id DESC');
           
        }
       else if(isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
            // $qry = 'SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( timelogs.`spend_hours` ) ) )  AS spend_hours, tasks.`id` AS id, tasks.`name` AS task_name, tasks.`task_priority`, 
            // users.name AS assign_by,tasks.`end_date`, tasks.`task_status`,
            // milestones.`name` AS milestone_name,employees.`name` AS assign_to,projects.`name` AS project_name FROM `tasks`
            // INNER JOIN `milestones` ON milestones.id = tasks.milestone_id
            // LEFT JOIN `users` ON tasks.assign_by = users.id
            // LEFT JOIN `projects` ON projects.id = tasks.project_id 
            // LEFT JOIN `employees` ON employees.id = tasks.employee_id
            // LEFT JOIN `timelogs` ON timelogs.task_id = tasks.id
            // WHERE tasks.deleted_at IS NULL AND milestones.deleted_at IS NULL AND projects.deleted_at IS NULL AND projects.project_manager = '.$emp[0]->id.' GROUP BY id ORDER BY id DESC';
            $qry = 'SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( timelogs.`spend_hours` ) ) )  AS spend_hours, tasks.`id` AS id, tasks.`name` AS task_name, tasks.`task_priority`, 
            users.name AS assign_by,tasks.`end_date`, tasks.`task_status`,
            milestones.`name` AS milestone_name,employees.`name` AS assign_to,projects.`name` AS project_name FROM `tasks`
            INNER JOIN `milestones` ON milestones.id = tasks.milestone_id
            LEFT JOIN `users` ON tasks.assign_by = users.id
            LEFT JOIN `projects` ON projects.id = tasks.project_id 
            LEFT JOIN `employees` ON employees.id = tasks.employee_id
            LEFT JOIN `timelogs` ON timelogs.task_id = tasks.id
            WHERE tasks.deleted_at IS NULL AND milestones.deleted_at IS NULL AND projects.deleted_at IS NULL GROUP BY id ORDER BY id DESC';
            $$module_name = DB::select($qry);
            
        }
         else
         {
            $$module_name = DB::select('SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( timelogs.`spend_hours`)))  AS spend_hours, tasks.`id`, tasks.`name` AS task_name, tasks.`task_priority`,
            users.name AS assign_by, tasks.`end_date`, tasks.`task_status`, milestones.`name` AS milestone_name, employees.`name` AS assign_to, projects.`name` AS project_name
             FROM `tasks` INNER JOIN `milestones` ON milestones.id = tasks.milestone_id 
             LEFT JOIN `users` ON tasks.assign_by = users.id
             LEFT JOIN `projects` ON projects.id = tasks.project_id 
             LEFT JOIN `employees` ON employees.id = tasks.employee_id  
             LEFT JOIN `timelogs` ON timelogs.task_id = tasks.id
             WHERE tasks.deleted_at IS NULL AND milestones.deleted_at IS NULL AND projects.deleted_at IS NULL AND tasks.employee_id = '.$emp[0]->id.' AND tasks.status = 1   GROUP BY id ORDER BY id DESC');      
           }
           
        $data = $$module_name;
        foreach ($data as $datan) {
            $task_id = $datan->id;
            
            if(isset($datan->project_id)){
               
                $project_id = $datan->project_id;
                // $checkright = DB::select('SELECT * FROM `timelogrights` WHERE project_id = '.$project_id.' AND task_id = '.$task_id.' AND employee_id = '.$emp[0]->id.' AND deleted_at IS NULL');
                $checkright = DB::select('SELECT * FROM `timelogrights` WHERE project_id = '.$project_id.' AND task_id = '.$task_id.' AND employee_id = '.$emp[0]->id.' AND deleted_at IS NULL AND CURRENT_DATE() <= end_date');
               
                if(isset($checkright) && !empty($checkright)){
                    $add_right = $checkright[0]->add_rights;
                    $edit_right = $checkright[0]->edit_rights;
                    $delete_right = $checkright[0]->delete_rights;
                    $datan->add_right = $add_right;
                }
          
            }
        //     $module_name1 ='SELECT id,spend_hours FROM `timelogs` WHERE task_id='.$task_id;
        //   // $module_name1 ='SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `spend_hours` ) ) ) FROM `timelogs` WHERE task_id='.$task_id;
           
        //     $spend_hrs_res = DB::select($module_name1);

            
        //     $hrs_arr = array();
        //     for ($i = 0; $i < count($spend_hrs_res); $i++) {
        //         $hrs_arr[] = $spend_hrs_res[$i]->spend_hours;
        //     }
           
        //     $total = 0;
        //     foreach ($hrs_arr as $element) :
        //         $temp = explode(":", $element);
        //         $total += (int) $temp[0] * 3600;
        //         $total += (int) $temp[1] * 60;
        //         $total += (int) $temp[2];
        //     endforeach;
        //     $formatted = sprintf(
        //         '%02d:%02d:%02d',
        //         ($total / 3600),
        //         ($total / 60 % 60),
        //         $total % 60
        //     );
            
            // $checktimelog = DB::select('SELECT * FROM `timelogs` WHERE task_id = '.$task_id);
            // if(!empty($checktimelog))
            // {
            //         $datan->timelog=1;
            // }
            // else
            // {
            //     $datan->timelog=0;
            // }
            //$query ='SELECT * FROM `timelogs` WHERE task_id = '.$task_id;
            //var_dump($datan);
                 
            $arr[] = $datan;

            
        }
        echo json_encode(array($arr));

        /*return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view('backend.includes.action_column', compact('module_name', 'data'));
                        })
                        ->editColumn('name', '<strong>{{$name}}</strong>')
                        ->editColumn('milestone_id', function ($data) {
                            //var_dump($data->milestone_id);
                            $milestone = \DB::select('SELECT name from milestones WHERE id = ?', [$data->milestone_id]);
                            //var_dump($milestone);
                            if(isset($milestone) && !empty($milestone)){
                                $data->milestone_id = $milestone[0]->name;
                            }
                            return $data->milestone_id;
                        })
                        ->editColumn('task_priority', function ($data) {
                            if(isset($data->task_priority) && !empty($data->task_priority) && $data->task_priority == '1'){
                                $data->task_priority = 'High';
                            }
                            elseif(isset($data->task_priority) && !empty($data->task_priority) && $data->task_priority == '2'){
                                $data->task_priority = 'Mid';
                            }
                            elseif(isset($data->task_priority) && !empty($data->task_priority) && $data->task_priority == '3'){
                                $data->task_priority = 'Low';
                            }
                            return $data->task_priority;
                        })
                        ->editColumn('assign_by', function ($data) {
                            //var_dump($data->milestone_id);
                            $user_name = \DB::select('SELECT name from users WHERE id = ?', [$data->assign_by]);
                            //var_dump($milestone);
                            if(isset($user_name) && !empty($user_name)){
                                $data->assign_by = $user_name[0]->name;
                            }
                            return $data->assign_by;
                        })
                        ->editColumn('status', function ($data) {
                            if(isset($data->status) && !empty($data->status) && $data->status == 1){
                                $data->status = 'Published';
                            }
                            elseif(isset($data->status) && $data->status == 0){
                                $data->status = 'Unpublished';
                            }
                            elseif(isset($data->status) && !empty($data->status) && $data->status == 2){
                                $data->status = 'Draft';
                            }
                            return $data->status;
                        })
                        // ->editColumn('updated_at', function ($data) {
                        //     $module_name = $this->module_name;

                        //     $diff = Carbon::now()->diffInHours($data->updated_at);

                        //     if ($diff < 25) {
                        //         return $data->updated_at->diffForHumans();
                        //     } else {
                        //         return $data->updated_at->isoFormat('llll');
                        //     }
                        // })
                        ->rawColumns(['name', 'action'])
                        ->make(true);*/
    }

    public function submit_log_data(Request $request){
        $task_id = $request->task_id;
        $log_date = Carbon::now();
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $spend_hours = $request->spend_hours;
        $log_name = $request->logname;
        $log_desc = $request->logdesc;
        $arr_ids = DB::select('SELECT `project_id`, `milestone_id`, `employee_id` FROM `tasks` WHERE id = '.$task_id);
        //var_dump($arr_ids);
        $project_id = $milestone_id = $employee_id = '';
        if(isset($arr_ids) && !empty($arr_ids)){
            $project_id = $arr_ids[0]->project_id;
            $milestone_id = $arr_ids[0]->milestone_id;
            $employee_id = $arr_ids[0]->employee_id;
        }
        $user = Auth::id();
        $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
        $ins_qry = 'INSERT INTO `timelogs`(`project_id`, `milestone_id`, `employee_id`, `task_id`, `name`, `description`, `log_date`, `start_time`, `end_time`, `spend_hours`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES ('.$project_id.','.$milestone_id.','.$employee_id.','.$task_id.',"'.$log_name.'","'.$log_desc.'","'.$log_date.'","'.$start_time.'","'.$end_time.'","'.$spend_hours.'","'.$log_date.'","'.$log_date.'","'.$emp[0]->id.'","'.$emp[0]->id.'")';
        $log_ins = DB::insert($ins_qry);
        //var_dump($log_ins);
        if($log_ins){
            echo 'Log has been added successfully.';
            //return true;
            exit;
        }
        else{
            echo 'Log has not added.';
            //return false;
            exit;
        }
    }

    public function change_task_status(Request $request){
        $task_id = $request->task_id;
        $task_status = $request->task_status;
        if($task_status == 'closed'){
            $up_qry = 'UPDATE `tasks` SET `task_status` = 2 WHERE tasks.id = '.$task_id;
        }
        elseif($task_status == 'new'){
            $up_qry = 'UPDATE `tasks` SET `task_status` = 1 WHERE tasks.id = '.$task_id;
        }
        
        //echo $ins_qry;
        $log_up = DB::update($up_qry);
        //var_dump($log_ins);
        if($log_up){
            echo 'Log has been added successfully.';
            //return true;
            exit;
        }
        else{
            echo 'Log has not added.';
            //return false;
            exit;
        }
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

        if(isset($request->q) && !empty($request->q)){
            $term = trim($request->q);

            if (empty($term)) {
                //return response()->json([]);
                $query_data = $module_model::select()->get();
            }
            else{
                $query_data = $module_model::where('milestone_id', '=', $term)->get();
            }
        }
        elseif (isset($request->p_id) && !empty($request->p_id)) {
            $term = trim($request->p_id);

            if (empty($term)) {
                //return response()->json([]);
                $query_data = $module_model::select()->get();
            }
            else{
                $query_data = $module_model::where('project_id', '=', $term)->get();
            }
        }
        else{
            $query_data = $module_model::select()->get();
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

    function submit_manual_log(Request $request){
        $task_id = $request->task_id;
        $log_date = $request->log_date;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $spend_hours = $request->spend_hours;
        $log_name = $request->name;
        $log_desc = $request->description;

        $arr_ids = DB::select('SELECT `project_id`, `milestone_id`, `employee_id` FROM `tasks` WHERE id = '.$task_id);
        // var_dump($arr_ids);
        $project_id = $milestone_id = $employee_id = '';
        if(isset($arr_ids) && !empty($arr_ids)){
            $project_id = $arr_ids[0]->project_id;
            $milestone_id = $arr_ids[0]->milestone_id;
            $employee_id = $arr_ids[0]->employee_id;
        }
        $user = Auth::id();
        $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
        $ins_qry = 'INSERT INTO `timelogs`(`project_id`, `milestone_id`, `employee_id`, `task_id`, `name`, `log_date`, `start_time`, `end_time`, `spend_hours`, `description`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES ('.$project_id.','.$milestone_id.','.$employee_id.','.$task_id.',"'.$log_name.'","'.$log_date.'","'.$start_time.'","'.$end_time.'","'.$spend_hours.'","'.$log_desc.'","'.$log_date.'","'.$log_date.'","'.$emp[0]->id.'","'.$emp[0]->id.'")';
        //echo $ins_qry;
        $log_ins = DB::insert($ins_qry);
        //var_dump($log_ins);
        if($log_ins){
            return true;
            //return true;
            exit;
        }
        else{
            return false;
            //return false;
            exit;
        }
    }
    
    public function fetch_dropdown_value(Request $request){
        $task_id = $request->task_id;
        $qry = 'select t.`project_id`, p.`name` AS "proname", t.`milestone_id`, m.`name` AS "milename", t.`employee_id`, e.`name` AS "empname", tt.name AS "tasktypename", t.task_type from `tasks` AS t JOIN `projects` AS p ON p.id = t.project_id JOIN `milestones` AS m ON m.id = t.milestone_id JOIN `employees` AS e ON e.id = t.employee_id JOIN `tasktypes` AS tt ON tt.id = t.task_type WHERE t.id = '.$task_id;
        // echo $qry;
        $dept = DB::select($qry);
        //print_r($dept);
        if($dept){
            $departments = json_encode($dept[0]);
            return $departments;    
            exit;
        }
        else{
            return false;
            exit;
        }
    }
}
