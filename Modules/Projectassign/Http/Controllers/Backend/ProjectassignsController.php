<?php

namespace Modules\Projectassign\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectassignsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Projectassigns';

        // module name
        $this->module_name = 'projectassigns';

        // directory path of the module
        $this->module_path = 'projectassign::backend';

        // module icon
        $this->module_icon = 'fas fa-projectassigns';

        // module model name, path
        $this->module_model = "Modules\Projectassign\Entities\Projectassign";
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
        // echo 'Jhanvi';
        // die;

        // echo '<pre>';
        // var_dump($request);
        // die;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $validatedData = $request->validate([
           
           // 'slug' => 'nullable|max:191|unique:'.$module_model.',slug',
        ]);

       
        // print_r($_POST);
        array_values($_POST);
        $project_id = $_POST['project_id'];
        $employee_id = $_POST['employee_id'];
        // print_r($project_id);
        // print_r($employee_id);
        // die;
        $sql = DB::select('SELECT * FROM `projectassigns` WHERE employee_id = '.$employee_id.' AND project_id ='.$project_id);

        // echo '<pre>';
        // print_r($sql);
        if($sql)
        {
           echo  '<script>';  
           echo 'alert("Employee already assigned.")';  
           echo '</script>';
        //    break;
        
        flash(icon().' '.Str::singular($module_title)."' This emplyee is already assigned!")->warning()->important();
        }
        else
        {

           echo '<script>';  
           echo 'alert("New employee assigned to the project")';  
           echo '</script>';
          
           $$module_name_singular = $module_model::create($request->except('image'));

           flash(icon().' '.Str::singular($module_title)."' Employee assigned successfully!")->success()->important();

           logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);
        }
        
        // if ($request->image) {
            
        //     $media = $$module_name_singular->addMedia($request->file('image'))->toMediaCollection($module_name);
        //     $$module_name_singular->image = $media->getUrl();
        //     $$module_name_singular->save();
        // }

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
            //'name' => 'required|max:191|unique:'.$module_model.',name,'.$id,
            // 'slug' => 'nullable|max:191|unique:'.$module_model.',slug,'.$id,
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

        return redirect()->route("backend.projectassigns.show", $$module_name_singular->id);
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
        $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
        if(isset($user) && !empty($user) && $role_name[0]->name == 'super admin')
        {
            $$module_name = DB::select('SELECT `pro`.`id`,`pro`.`name`, `pr`.`name` AS `project_name`, `dept`.`name` AS `department_name`, `emp`.`name` AS `employee_name` FROM `projectassigns` AS `pro` LEFT JOIN `departments` AS `dept` ON `pro`. `department_id` = `dept`.`id` LEFT JOIN `employees` AS `emp` ON `pro`. `employee_id` = `emp`.`id` LEFT JOIN `projects` AS `pr` ON `pro`. `project_id` = `pr`.`id` WHERE `pro`.deleted_at  IS NULL AND `pr`.deleted_at IS NULL  GROUP BY `pro`.`id`');

        }
         else
            {
                $$module_name = DB::select('SELECT `pro`.`id`,`pro`.`name`, `pr`.`name` AS `project_name`, `dept`.`name` AS `department_name`, `emp`.`name` AS `employee_name` FROM `projectassigns` AS `pro` LEFT JOIN `departments` AS `dept` ON `pro`. `department_id` = `dept`.`id` LEFT JOIN `employees` AS `emp` ON `pro`. `employee_id` = `emp`.`id` LEFT JOIN `projects` AS `pr` ON `pro`. `project_id` = `pr`.`id` WHERE `pro`.deleted_at  IS NULL AND `pr`.deleted_at IS NULL AND `pro`.`created_by`='.$user.' GROUP BY `pro`.`id`');
             }

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
        // $data = $$module_name;

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
        $proassign_id = $request->proassign_id;
        $qry = 'select pa.`project_id`, p.`name` AS "proname", d.name AS "deptname", pa.department_id, e.name AS "empname", pa.employee_id from `projectassigns` AS pa JOIN `projects` AS p ON p.id = pa.project_id JOIN `departments` AS d ON d.id = pa.department_id JOIN `employees` AS e ON e.id = pa.employee_id WHERE pa.id = '.$proassign_id;
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
