<?php

namespace Modules\Resource\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ResourcesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Resources';

        // module name
        $this->module_name = 'resources';

        // directory path of the module
        $this->module_path = 'resource::backend';

        // module icon
        $this->module_icon = 'fas fa-resources';

        // module model name, path
        $this->module_model = "Modules\Resource\Entities\Resource";
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

        return redirect()->route("backend.resources.show", $$module_name_singular->id);
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

        $$module_name = $module_model::select('id', 'name', 'slug', 'updated_at');

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

        //$query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('slug', 'LIKE', "%$term%")->limit(7)->get();
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

    public function get_task_detail()
    {
        // ini_set('memory_limit', '-1');
        $user = Auth::id();
        $role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = '.$user);
        $role_name = DB::select('select `name` from `roles` where `id` = '.$role_id[0]->role_id);
        $emp = DB::select('select `id` from `employees` where `user_id` = '.$user);
        $status = DB::select('SELECT * FROM `tasks` Where `status` = 0');
        $module_name = $this->module_name;
        $data = array();
        // print_r($status);
        // die;
        
        if(isset($user) && !empty($user) && ($role_name[0]->name == 'super admin' || $role_name[0]->name == 'manager')) {
            $qry = "SELECT e.name, t.start_date AS 'startDate', t.end_date AS 'endDate', t.estimated_hours FROM `employees` AS e LEFT JOIN `tasks` AS t ON t.`employee_id` = e.id WHERE t.deleted_at IS NULL AND t.status = 1 AND t.task_status <> 2";
            $$module_name = DB::select($qry);
           
        }
        
        $cnt = 1;
        $obj_data1 = array();
        $name_emp = array();
        $weekends = array();
        if(isset($$module_name) && !empty($$module_name)) {
            foreach($$module_name as $key => $value){
                // $value->id = $cnt;
                // var_dump($value);
                $start = strtotime($value->startDate);
                $end = strtotime($value->endDate);
                $count = 0;
                while(date('d-m-Y', $start) < date('d-m-Y', $end)){
                $count += date('N', $start) < 6 ? 1 : 0;
                $start = strtotime("+1 day", $start);
                }
                $tot_days = $count+1;
                // echo $value->name . ' '.$tot_days;
                // echo $value->endDate;
                $day_work = $value->estimated_hours / $tot_days;
                $per_day_hour = $value->estimated_hours / 8;
                // var_dump($per_day_hour < $tot_days && $per_day_hour!=8);
                // var_dump(is_float($per_day_hour));
                $new_end_dt = '';
                $new_endDate = '';
                $whole = 0;
                $fraction = 0;
                // var_dump(is_float($per_day_hour));
                if(is_float($per_day_hour)){
                    $n = $per_day_hour;
                    $whole = floor($n);      // 1
                    $fraction = $n - $whole; // .25
                    $remain_hrs = $fraction * 8;
                    switch ($remain_hrs) {
                        case '7.5':
                            $partial_class = 'redH7-5';
                            break;

                        case '7':
                            $partial_class = 'redH7';
                            break;
                        
                        case '6.5':
                            $partial_class = 'redH6-5';
                            break;

                        case '6':
                            $partial_class = 'redH6';
                            break;
                        
                        case '5.5':
                            $partial_class = 'redH5-5';
                            break;

                        case '5':
                            $partial_class = 'redH5';
                            break;

                        case '4.5':
                            $partial_class = 'redH4-5';
                            break;

                        case '4':
                            $partial_class = 'redH4';
                            break;
                        
                        case '3.5':
                            $partial_class = 'redH3-5';
                            break;

                        case '3':
                            $partial_class = 'redH3';
                            break;

                        case '2.5':
                            $partial_class = 'redH2-5';
                            break;

                        case '2':
                            $partial_class = 'redH2';
                            break;

                        case '1.5':
                            $partial_class = 'redH1-5';
                            break;

                        case '1':
                            $partial_class = 'redH1';
                            break;

                        case '0.5':
                            $partial_class = 'redH0-5';
                            break;
                        default:
                            $partial_class = 'redH4';
                            break;
                    }
                    // var_dump($whole);
                    if($per_day_hour < 8 && $per_day_hour!=8){
                        if(isset($whole) && !empty($whole)){
                            $inc_day = '+'.$whole.' days';
                            // var_dump($this->addDays($whole));
                            // $new_end_dt = $this->addDays($whole-1);
                            $new_end_dt = $this->sumDays($whole-1, 'd-m-Y', $value->startDate);
                        }
                        elseif ($whole == 0) {
                            // var_dump($value->startDate);
                            $new_end_dt = $value->startDate;
                        }
                        else{
                            $inc_day = '+'.$per_day_hour.' days';
                            // $new_end_dt = $this->addDays($per_day_hour);
                            $new_endDate = $this->sumDays($per_day_hour-1, 'd-m-Y', $value->startDate);
                        }
                        // var_dump($inc_day);
                        // var_dump($value->startDate);
                        // $new_end_dt = strtotime($inc_day, $value->startDate);
                        // var_dump($new_end_dt);
                        // echo $effectiveDate = date('d-m-Y', strtotime($inc_day, strtotime($value->startDate)));
                        
                    }
                }
                elseif (is_int($per_day_hour)) {
                    if($per_day_hour < 8 && $per_day_hour!=8){
                        if(isset($whole) && !empty($whole)){
                            $inc_day = '+'.$whole.' days';
                            // var_dump($this->addDays($whole));
                            // $new_end_dt = $this->addDays($whole-1);
                            $new_end_dt = $this->sumDays($whole-1, 'd-m-Y', $value->startDate);
                        }
                        else{
                            $inc_day = '+'.$per_day_hour.' days';
                            // $new_end_dt = $this->addDays($per_day_hour);
                            $new_endDate = $this->sumDays($per_day_hour-1, 'd-m-Y', $value->startDate);
                        }
                        // var_dump($inc_day);
                        // var_dump($value->startDate);
                        // $new_end_dt = strtotime($inc_day, $value->startDate);
                        // var_dump($new_end_dt);
                        // echo $effectiveDate = date('d-m-Y', strtotime($inc_day, strtotime($value->startDate)));
                        
                    }
                }
                $v1 = (array) $value;
                $v1['name'] = strtolower(str_replace(' ', '_', $value->name));
                $v1['customClass'] = 'redClass';
                $v1['title'] = 'booked';
                // var_dump(isset($new_end_dt) && !empty($new_end_dt));
                // var_dump(isset($new_endDate) && !empty($new_endDate));
                if(isset($new_end_dt) && !empty($new_end_dt)){
                    // var_dump($new_end_dt);
                    $v1['endDate'] = $new_end_dt;
                    if($new_end_dt == $value->startDate && $whole == 0){
                        $v1['customClass'] = 'redHClass greenHClass '.$partial_class;
                    }
                }
                elseif (isset($new_endDate) && !empty($new_endDate)) {
                    $v1['endDate'] = $new_endDate;
                }
                // var_dump($value);
                $obj_data = array_merge(array('id' => $cnt), $v1);
                // var_dump($obj_data); 
                $obj_data1[] = (object) $obj_data;
                // For add half color class to last date
                // var_dump(isset($new_end_dt) && !empty($new_end_dt));
                if(isset($new_end_dt) && !empty($new_end_dt) && $whole != 0){
                    $v1 = (array) $value;
                    $v1['name'] = strtolower(str_replace(' ', '_', $value->name));
                    $v1['customClass'] = 'redHClass greenHClass '.$partial_class;
                    $v1['title'] = 'booked';
                    $v1['startDate'] = $this->sumDays(1, 'd-m-Y', $new_end_dt); //date('d-m-Y', strtotime('+1 day', strtotime($new_end_dt)));
                    $v1['endDate'] = $this->sumDays(1, 'd-m-Y', $new_end_dt); //date('d-m-Y', strtotime('+1 day', strtotime($new_end_dt)));
                    // var_dump($this->sumDays(4, 'd-m-Y', $new_end_dt));
                    $cnt++;
                    $obj_data_new = array_merge(array('id' => $cnt), $v1);
                    // var_dump($obj_data_new); 
                    $obj_data1[] = (object) $obj_data_new;
                }
                // For overloading code
                $emp_name = $v1['name'];
                $name_emp[$emp_name][] = $v1;
                // var_dump($name_emp);
                // $name_emp[$emp_name][] = $v1['endDate']; 
                // For Available dates code
                $today = date('d-m-Y');
                $date = strtotime($today .' -6 month');
                $edate = strtotime($today .' +1 year');
                // code for vacation weekend days
                //$weekends_arr[] = array('id' => '101'.$cnt, 'name' => $v1['name'], 'startDate' => date('d-m-Y', $date), 'endDate' => date('d-m-Y', $edate), 'customClass' => 'grayClass', 'title'=>'Vacation');
                // while (date("d-m-Y", $date) != date("d-m-Y", $edate)) {
                //     $day_index = date("w", $date);
                //     if ($day_index == 0 || $day_index == 6) {
                //         // Print or store the weekends here
                //         $cnt++;
                //         $weekends[] = array('id' => $cnt, 'name' => $v1['name'], 'startDate' => date('d-m-Y', $date), 'endDate' => date('d-m-Y', $date), 'customClass' => 'grayClass', 'title'=>'Vacation');
                //     }
                //     $date = strtotime(date("d-m-Y", $date) . "+1 day");
                // }
                $cnt++;
                $carr[] = array('id' => $cnt, 'name' => $v1['name'], 'startDate' => date('d-m-Y', $date), 'endDate' => date('d-m-Y', $edate), 'customClass' => 'greenClass', 'title'=>'Available' );
                $cnt++;
            }
        }
        // echo '<pre>';
        // print_r($name_emp);
        // echo '</pre>';
        // var_dump($obj_data1);
        if(isset($carr) && !empty($carr)){
            foreach($carr as $value){
                $obj_data1[] = (object) $value;
            }
        }
        // For vacation code
        // foreach($weekends as $value){
        //     $obj_data1[] = (object) $value;
        // }        
        // $obj_data1 = array_push($obj_data1, $carr);
        if(isset($obj_data1) && !empty($obj_data1)){
            $data = $obj_data1;
        }
        else{
            $rec = array();
            // $qry = "SELECT `name` FROM `employees` WHERE `deleted_at` IS NULL";
            $qry = "SELECT e.name FROM `employees` AS e LEFT JOIN `tasks` AS t ON t.`employee_id` = e.id WHERE t.deleted_at IS NULL GROUP BY e.name";
            $rec = DB::select($qry);
            
            $data1 = $rec;
            // var_dump($data);
            $str_name = array();
            $cnt1 = 1;
            foreach($data1 as $value){
                $today = date('d-m-Y');
                $date = strtotime($today .' -6 month');
                $edate = strtotime($today .' +1 year');
                $str_emp_name = strtolower( str_replace(' ', '_', $value->name) );
                $available_emp[] = array('id' => $cnt1, 'name' => $str_emp_name, 'startDate' => date('d-m-Y', $date), 'endDate' => date('d-m-Y', $edate), 'customClass' => 'greenClass', 'title'=>'Available' );
                $cnt1++;
            }
            if(isset($available_emp) && !empty($available_emp)){
                foreach($available_emp as $value){
                    $data[] = (object) $value;
                }
            }
        }
        // var_dump($data);
        echo json_encode($data);
    }

    public function sumDays($days = 0, $format = 'd/m/Y', $actdate) {
        $incrementing = $days > 0;
        $days         = abs($days);
        $actualDate   = $actdate;
    
        while ($days > 0) {
            $tsDate    = strtotime($actualDate . ' ' . ($incrementing ? '+' : '-') . ' 1 days');
            $actualDate = date('d-m-Y', $tsDate);
    
            if (date('N', $tsDate) < 6) {
                $days--;
            }
        }
    
        return date($format, strtotime($actualDate));
    }

    public function addDays($days,$format="d-m-Y"){

        for($i=0;$i<$days;$i++){
            $day = date('N',strtotime("+".($i+1)."day"));
            if($day>5)
                $days++;
        }
        return date($format,strtotime("+$i day"));
    }

    public function get_emp_detail()
    {
        $rec = array();
        // $qry = "SELECT `name` FROM `employees` WHERE `deleted_at` IS NULL";
        $qry = "SELECT e.name FROM `employees` AS e LEFT JOIN `tasks` AS t ON t.`employee_id` = e.id WHERE t.deleted_at IS NULL GROUP BY e.name";
        $rec = DB::select($qry);
        
        $data = $rec;
        // var_dump($data);
        $str_name = array();
        foreach($data as $value){
            $str_name[] = strtolower( str_replace(' ', '_', $value->name) );
        }
        // $str_name = rtrim(rtrim($str_name, ' '), ',');
        // $str_name .= "]";
        echo json_encode($str_name);
    }
}
