<?php

namespace Modules\Timelogright\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TimelogrightsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Timelog Rights';

        // module name
        $this->module_name = 'timelogrights';

        // directory path of the module
        $this->module_path = 'timelogright::backend';

        // module icon
        $this->module_icon = 'fas fa-timelogrights';

        // module model name, path
        $this->module_model = "Modules\Timelogright\Entities\Timelogright";
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

        return redirect()->route("backend.timelogrights.show", $$module_name_singular->id);
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

        $$module_name = $module_model::select('id', 'name', 'project_id', 'task_id', 'employee_id','add_rights','edit_rights','delete_rights', 'start_date', 'end_date', 'status');

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view('backend.includes.action_column', compact('module_name', 'data'));
                        })
                        ->editColumn('name', '<strong>{{$name}}</strong>')
                        ->editColumn('project_id', function ($data) {
                            //var_dump($data->project_id);
                            $projects = \DB::select('SELECT name from projects WHERE id = ?', [$data->project_id]);
                            //var_dump($projects);
                            if(isset($projects) && !empty($projects)){
                                $data->project_id = $projects[0]->name;
                            }
                            return $data->project_id;
                        })
                        ->editColumn('task_id', function ($data) {
                            //var_dump($data->task_id);
                            $tasks = \DB::select('SELECT name from tasks WHERE id = ?', [$data->task_id]);
                            //var_dump($tasks);
                            if(isset($tasks) && !empty($tasks)){
                                $data->task_id = $tasks[0]->name;
                            }
                            return $data->task_id;
                        })
                        ->editColumn('employee_id', function ($data) {
                            //var_dump($data->employee_id);
                            $employees = \DB::select('SELECT name from employees WHERE id = ?', [$data->employee_id]);
                            //var_dump($employees);
                            if(isset($employees) && !empty($employees)){
                                $data->employee_id = $employees[0]->name;
                            }
                            return $data->employee_id;
                        })
                        ->editColumn('add_rights', function ($data) {
                            if(isset($data->add_rights) && !empty($data->add_rights) && $data->add_rights == 1){
                                $data->add_rights = 'Yes';
                            }
                            elseif(isset($data->add_rights) && $data->add_rights == 0){
                                $data->add_rights = 'No';
                            }
                            
                            return $data->add_rights;
                        })
                        ->editColumn('edit_rights', function ($data) {
                            if(isset($data->edit_rights) && !empty($data->edit_rights) && $data->edit_rights == 1){
                                $data->edit_rights = 'Yes';
                            }
                            elseif(isset($data->edit_rights) && $data->edit_rights == 0){
                                $data->edit_rights = 'No';
                            }
                            
                            return $data->edit_rights;
                        })
                        ->editColumn('delete_rights', function ($data) {
                            if(isset($data->delete_rights) && !empty($data->delete_rights) && $data->delete_rights == 1){
                                $data->delete_rights = 'Yes';
                            }
                            elseif(isset($data->delete_rights) && $data->delete_rights == 0){
                                $data->delete_rights = 'No';
                            }
                            
                            return $data->delete_rights;
                        })
                        // ->editColumn('status', function ($data) {
                        //     if(isset($data->status) && !empty($data->status) && $data->status == 1){
                        //         $data->status = 'Published';
                        //     }
                        //     elseif(isset($data->status) && $data->status == 0){
                        //         $data->status = 'Unpublished';
                        //     }
                        //     elseif(isset($data->status) && !empty($data->status) && $data->status == 2){
                        //         $data->status = 'Draft';
                        //     }
                        //     return $data->status;
                        // })
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
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
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

        // if (empty($term)) {
        //     return response()->json([]);
        // }

        $query_data = $module_model::select()->get();

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
        $timelogright_id = $request->timelogright_id;
        $qry = 'select tr.`project_id`, p.`name` AS "proname", t.name AS "taskname", tr.task_id, e.name AS "empname", tr.employee_id from `timelogrights` AS tr JOIN `projects` AS p ON p.id = tr.project_id JOIN `tasks` AS t ON t.id = tr.task_id JOIN `employees` AS e ON e.id = tr.employee_id WHERE tr.id = '.$timelogright_id;
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
