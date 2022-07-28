<?php

namespace Modules\Employee\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
// use Auth;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Employees';

        // module name
        $this->module_name = 'employees';

        // directory path of the module
        $this->module_path = 'employee::backend';

        // module icon
        $this->module_icon = 'fas fa-employees';

        // module model name, path
        $this->module_model = "Modules\Employee\Entities\Employee";
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

        return redirect()->route("backend.employees.show", $$module_name_singular->id);
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
        $module = trim($request->module);
        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = '.$user);
        $role_name = DB::select('select `name` from `roles` where `id` = '.$role_id[0]->role_id);
        
        if(isset($module) && $module=='task' && isset($term) && !empty($term)){
            $qry_emp = 'SELECT emp.id, emp.name FROM `employees` AS emp JOIN `projectassigns` AS pa ON emp.id = pa.employee_id JOIN projects AS p ON pa.project_id = p.id WHERE p.id = '.$term.' AND emp.deleted_at IS NULL GROUP BY emp.id';
            //echo $qry_emp;
            $query_data = DB::select($qry_emp);
        }
        elseif(isset($user) && !empty($user) && $role_name[0]->name == 'super admin'){
            $query_data = DB::select('SELECT employees.id, employees.name FROM `employees` LEFT JOIN roles ON roles.id = employees.employeerole LEFT JOIN employeeroles ON employeeroles.id = employees.employeerole WHERE employeeroles.id = 2');
            // print_r($query_data);
        }
        elseif(isset($user) && !empty($user) && $role_name[0]->name == 'manager') {
            if(isset($module) && $module=='task' && isset($term) && !empty($term)) {
                // echo 'select `id` from `employees` where `user_id` = '.$user;
                $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
                $query_data = DB::select('SELECT `employees`.id, `employees`.name FROM `employees` LEFT JOIN `projectassigns` ON `employees`.id = `projectassigns`.`employee_id` WHERE `projectassigns`.`project_id` = '.$term);
            }
            elseif(isset($module) && $module=='project') {
                $query_data = DB::select('SELECT employees.id, employees.name FROM `employees` LEFT JOIN roles ON roles.id = employees.employeerole LEFT JOIN employeeroles ON employeeroles.id = employees.employeerole WHERE employeeroles.id = 2');
            }
            elseif(isset($module) && $module=='projectassign')
            {
               $qry='SELECT e.id, e.name FROM `employees` AS e WHERE NOT EXISTS(SELECT p.`employee_id` FROM `projectassigns` AS p WHERE p.`employee_id` = e.`id` AND p.`project_id` ='.$term.')';
               $query_data=DB::select($qry);
            }
            else{
                $query_data = $module_model::select()->get();
            }
        }
        else
        {
            $query_data = $module_model::select()->get();
        }
        // echo '<pre>';
        // print_r($user_id);
        // die;

        //$query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('slug', 'LIKE', "%$term%")->limit(7)->get();

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

        $$module_name = $module_model::select('id', 'name', 'slug', 'status','employee_department','employeerole', 'created_by', 'updated_by', 'updated_at');

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view('backend.includes.action_column', compact('module_name', 'data'));
                        })
                        ->editColumn('name', '<strong>{{$name}}</strong>')
                        ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);

                            if ($diff < 25) {
                                return $data->updated_at->diffForHumans();
                            } else {
                                return $data->updated_at->isoFormat('llll');
                            }
                        })
                        ->editColumn('employee_department', function ($data) {
                            //var_dump($data->employee_department);
                            $departments = \DB::select('SELECT name from departments WHERE id = ?', [$data->employee_department]);
                            //var_dump($departments);
                            if(isset($departments) && !empty($departments)){
                                $data->employee_department = $departments[0]->name;
                            }
                            return $data->employee_department;
                        })
                        ->editColumn('employeerole', function ($data) {
                            //var_dump($data->employeerole);
                            $employeeroles = \DB::select('SELECT name from employeeroles WHERE id = ?', [$data->employeerole]);
                            //var_dump($employeeroles);
                            if(isset($employeeroles) && !empty($employeeroles)){
                                $data->employeerole = $employeeroles[0]->name;
                            }
                            return $data->employeerole;
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
                        ->editColumn('created_by', function ($data) {
                            //var_dump($data->milestone_id);
                            $user_name = \DB::select('SELECT name from users WHERE id = ?', [$data->created_by]);
                            //var_dump($milestone);
                            if(isset($user_name) && !empty($user_name)){
                                $data->assign_by = $user_name[0]->name;
                            }
                            return $data->assign_by;
                        })
                        ->rawColumns(['name', 'action'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    public function fetch_dropdown_value(Request $request){
        $emp_id = $request->emp_id;
        $qry = 'select e.`employee_department`, d.`name` AS "empdeptname", er.name AS "emprolename", e.employeerole, u.name AS "username", e.user_id from `employees` AS e JOIN `departments` AS d ON d.id = e.employee_department JOIN `employeeroles` AS er ON er.id = e.employeerole JOIN `users` AS u ON u.id = e.user_id WHERE e.id = '.$emp_id;
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