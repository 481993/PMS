<p>
    @lang("Displayed all the values of :module_name (Id: :id)", ['module_name'=>ucwords($module_name_singular), 'id'=>$$module_name_singular->id]).
</p>
<table class="table table-responsive-sm table-hover table-bordered">
    <?php
    // print_r($module_name_singular);
    // die;
  $userId = Auth::id();
     $module_name=$module_name_singular;
    //  echo "hello".$module_name;
    //  die();
    $all_columns = $$module_name_singular->getTableColumns();
    // echo '<pre>';
    // print_r($all_columns);
    // die;
    $all_columns1 = array();
    //var_dump($module_name == 'timelog');
    if($module_name == 'project')
    {
    
    $all_columns1[] =array('Field'=> "Total task",
            'Type' => "varchar(191)",
            'Null' =>"YES",
            'Key' => "",
            'Default' => "",
            'Extra' =>""
    );
    $all_columns1[] = array('Field'=> "Total employee",
            'Type' => "varchar(191)",
            'Null' =>"YES",
            'Key' => "",
            'Default' => "",
            'Extra' =>""
    );
    $all_columns1[] =array('Field'=> "Total milestone",
            'Type' => "varchar(191)",
            'Null' =>"YES",
            'Key' => "",
            'Default' => "",
            'Extra' =>""
    );
    }
    elseif($module_name == 'timelog') 
    {
       
       $all_columns1[] =array('Field'=> "Log Name",
                'Type' => "varchar(191)",
                'Null' =>"YES",
                'Key' => "",
                'Default' => "",
                'Extra' =>""
          );
        $all_columns1[] =array('Field'=> "Task Name",
                'Type' => "varchar(191)",
                'Null' =>"YES",
                'Key' => "",
                'Default' => "",
                'Extra' =>""
            );
    }
    $allcolumn2=array();
    foreach ($all_columns1 as $value) {
        $allcolumn2[] = (object) $value;
    }
$all_columns=array_merge($all_columns,$allcolumn2);
    ?>
    <thead>
        <tr>
            <th scope="col">
                <strong>
                    @lang('Name')
                </strong>
            </th>
            <th scope="col">
                <strong>
                    @lang('Value')
                </strong>
            </th>
        </tr>
    </thead>
    <tbody>
       
        {{-- // $module_name = DB::select('SELECT count(`id`) 
        // AS total_task FROM `tasks` WHERE project_id=' . $datan->id . ' ');
        //     $total_task = $$module_name[0]->total_task;
        //     $datan->total_task = $total_task; 
               // $query = DB::select('SELECT count(employee_id) AS total_employee FROM `projectassigns` WHERE project_id='$$module_name_singular->id'');
               // $a=$query[1];
           // $total_employee = $$module_name[0]->total_employee;
           // $datan->total_employee = $total_employee;
            // var_dump($query);
            // die(); --}}

        @foreach ($all_columns as $column)
        <tr>
            <td>
                <strong>
                   

                    <?php 
                    if($column->Field == 'departments_id')
                    {
                        $column->Field = 'departments_name';
                    }
                    if($module_name == 'task')
                   {
                    if($column->Field == 'project_id')
                    {
                        $column->Field = 'Project name';
                    }
                    if($column->Field == 'milestone_id')
                    {
                        $column->Field = 'Milestone name';
                    }
                    if($column->Field == 'employee_id')
                    {
                        $column->Field = 'Employee name';
                    }
                    
                }
                if($module_name == 'milestone')
                   {
                if($column->Field == 'project_id')
                    {
                        $column->Field = 'Project name';
                    }
                }
                    // var_dump($column->Field);
                    // die;
                    ?>

                    {{ label_case($column->Field) }}
                   
                </strong>
            </td>
            <td>
              
                {!! show_column_value($$module_name_singular, $column) !!}
             
               

            </td>
            {{-- <td>
                {!! var_dump($query); !!}
            </td> --}}
        </tr>
        @endforeach
        <tr>

        </tr>
    </tbody>
</table>

{{-- Lightbox2 Library --}}
<x-library.lightbox />