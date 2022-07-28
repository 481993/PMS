<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

$user = Auth::user()->id;
$role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = ' . $user);
$role_name = DB::select('select `name` from `roles` where `id` = ' . $role_id[0]->role_id);
$emp = DB::select('select `id`, `name` from `employees` where `user_id` = ' . $user);
// var_dump($emp);
// if(isset($user) && !empty($user) && $role_name[0]->name == 'user')
// {
//     //  var_dump($user);
//     // die();
// }
$user_role = $role_name[0]->name;
 

?>
@extends('backend.layouts.app')

@section('title')
    {{ $module_action }} {{ $module_title }}
@endsection

@section('breadcrumbs')
    <x-backend-breadcrumbs>
        <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ $module_title }}
        </x-backend-breadcrumb-item>
    </x-backend-breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title mb-0">
                        <i class=""></i><i class="fas fa-list-ul c-sidebar-nav-icon"></i> {{ $module_title }}
                        {{-- <small class="text-muted">Data Table {{ $module_action }}</small> --}}
                    </h4>
                    {{-- <div class="small text-muted">
                    {{ Str::title($module_name) }} Management Dashboard
            </div> --}}
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <x-buttons.create route='{{ route("backend.$module_name.create") }}'
                            title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}" />

                        <div class="btn-group" role="group" aria-label="Toolbar button groups">
                            <div class="btn-group" role="group">
                                   {{-- <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                                    <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                        <i class="fas fa-eye-slash"></i> View trash
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success alert-important" id="alert-message" role="alert" style="width: 100%;
                    margin: 20px; display:none;"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">�</button>
                    <i class="fas fa-check"></i>status changed successfully.
                </div>
            </div>
            <!--/.row-->

            <div class="row mt-4">
                <div class="col">
                    <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                {{-- <th>
                                #No
                            </th> --}}
                                <th>
                                    Project Name
                                </th>
                                <th>
                                    Milestone
                                </th>
                                <th>
                                    Task Name
                                </th>
                                <th>
                                    Priority
                                </th>
                                <?php  if($user_role != 'manager')
                                {?>
                                <th>
                                    Assigned By
                                </th>
                                <?php }?>
                                <th>
                                    Spend Hours
                                </th>
                                <?php  if($user_role != 'user')
                                {?>
                                <th>
                                    Assigned To
                                </th>
                                <?php }?>
                                <th>
                                    Due Date
                                </th>
                                <th>
                                    Task Status
                                </th>
                                <th class="text-left">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id='taskbidders'>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-7 col-xs-12 timer-start">
                    <div class="float-left">
                        <section class="chat-window docked" style="display:none">
                            <div class="chat-header">
                                <span id="hours">00:</span>
                                <span id="mins">00:</span>
                                <span id="seconds">00</span>
                                <span class="play-btn" ><i class="fa fa-play" id="start" style="display: none" aria-hidden="true"></i>
                                    <i class="fa fa-pause" id="stop" aria-hidden="true"></i></span>
                              <span class="close"></span>
                            </div>
                            <div class="chat-body">
                              <div class="form-container">
                                <div class="form-group">
                                    <label for="msg"><b>Task</b></label>
                                    <input type="text" class="form-control txtTaskname" name="task_name"
                                        placeholder="Enter Taskname" readonly />
                                </div>
                                <div class="form-group">
                            <input type="text" name="txtTimeLog" id="txtTimeLog" maxlength="15"
                                class='txtTimeLog form-control' placeholder="Enter Log Name"><br />
                            <textarea name='txtareaLogdesc' id='txtareaLogdesc' class='txtareaLogdesc form-control'
                                placeholder="Enter work description"></textarea>
                            <input type="hidden" name="txtTaskid" id="txtTaskid" class="txtTaskid">
                                </div>
                                <button id="starttime" class="btn2">Start Timer</button>
                            <button type="button" class="submitLog" id="submitlog">Submit Log</button>
                            <span class="lblResponse"></span>
                        </div>
                        </section>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="float-right">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Time Log</h5> <button type="button"
                            class="close" data-dismiss="modal" aria-label="Close"> <span
                                aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="timelogform">
                            <!-- <div class="form-row">
                                    <div class="form-group col-md-6"> <label for="project_id">Project</label> <input type="int" class="form-control" id="project_id" placeholder="Project Name"> </div>
                                    <div class="form-group col-md-6"> <label for="milestone_id">Milestone</label> <input type="int" class="form-control" id="milestone_id" placeholder="Milestone Name"> </div>
                                </div> -->
                            <div class="form-group">
                                <!-- <label for="employee_id">Employee</label> <input type="int" class="form-control" id="employee_id" placeholder="Employee Name"> </div> -->
                                <div class="form-group"> <label for="task_id">Task</label>
                                    <input type="text" class="form-control tfTaskname" id="task_id" placeholder="Task Name"
                                        readonly="true">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="log_date">Log Date</label>
                                        <input type="date" class="form-control" id="log_date" name="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="start_time">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" placeholder="Start Time">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="end_time">End Time</label>
                                        <input type="time" class="form-control" id="end_time" placeholder="End Time">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="spend_hours">Spend Hours</label>
                                        <input type="text" class="form-control" id="spend_hours"
                                            placeholder="Spend Hours">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description"
                                            placeholder="Description">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success btn-create" id="submit" Value="Submit">
                                <input type="hidden" name="task_id" class="tfTaskid" id="tfTaskid">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    

    <style>
        #lap {
            margin-top: 0.5em;
        }

        #main {
            text-align: center;
            white-space: nowrap;
        }

        #main button {
            padding: 0.4em;
            font-size: 1.1em;
        }

        #disp {
            background-color: white;
            font-size: 2em;
            width: 7.25em;
            font-family: "Courier New";
        }

        #main button,
        #disp {
            width: 8em;
            vertical-align: middle;
        }

        #remote {
            position: absolute;
            top: 1px;
            right: 1px;

            visibility: hidden;
        }

        /* menus */
        /* General Styles for Menu  */
        .menuBackground {
            background: brown;
            text-align: center;
        }

        .dropDownMenu a {
            color: #321fdb;
        }
        .btn2 {
        position: relative; 
        text-transform: none; 
        transition: all .15s ease; 
        letter-spacing: .025em; 
        font-size: .875rem; 
        will-change: transform; 
        color: #fff; 
        padding: 7px 20px; 
        background-color: #321fdb; 
        margin-top: 15px; 
        margin-bottom: 20px; 
         border-color: transparent; 
        border-radius: 50px;
        }
        .dropDownMenu,
        .dropDownMenu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .dropDownMenu li {
            position: relative;
        }

        .dropDownMenu a {
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }

        .dropDownMenu a:hover {
            background: #000;
        }


        /* Level 1 Drop Down */
        .dropDownMenu>li {
            display: inline-block;
            vertical-align: top;
            margin-left: -4px;
            /* solve the 4 pixels spacing between list-items */
        }

        .dropDownMenu>li:first-child {
            margin-left: 0;
        }

        /* Level 2 */
        .dropDownMenu ul {
            box-shadow: 2px 2px 15px 0 rgba(0, 0, 0, 0.5);
        }

        .dropDownMenu>li>ul {
            text-align: left;
            display: none;
            background: #fff;
            position: absolute;
            top: 100%;
            left: 0;
            width: 240px;
            z-index: 999999;
            /* if you have YouTube iframes, is good to have a bigger z-index so the video can appear above the video */
        }

        /* Level 3 */
        .dropDownMenu>li>ul>li>ul {
            text-align: left;
            display: none;
            background: darkcyan;
            position: absolute;
            left: 100%;
            top: 0;
            z-index: 9999999;
        }
         .instructions {
  width: 100vw!!important;
  height: 100vh!important;
  display: flex!important;
  justify-content: center!important;
  align-items: center!important;
}
.instructions h1 {
  text-align: center;
  font-size: calc(100vw / 7);
}
.chat-body label{
  display: block;
  padding: 0px 0px 0px 5px;
  font-weight: 700;
  color: #727272;
  font-size: 12px;
}
.chat-body select{
  box-shadow: none;
  background-color: transparent;
  background-image: none;
  border: 1px solid #E7EAEA;
  background-repeat: initial;
}
.chat-window {
  position: fixed!important;
  bottom: 0!important;
  width: 300px!important;
  height: 350px!important;
  transition: all ease-out 250ms!important;
}
.chat-window.docked {
  transform: translateY(305px)!important;
}
.chat-window p {
  margin: 0!important;
}
.chat-window .chat-header {
  height: 45px!important;
  border-radius: 6px 6px 0 0!important;
  background: #f6911d;
  position: relative;
  cursor: pointer;
}
.close:not(:disabled):not(.disabled):focus, .close:not(:disabled):not(.disabled):hover {
    opacity: 1;
}
.chat-window .chat-header {
  display: block;
  padding: 0 1em 0 2em;
  color: #fff;
  font-weight: 700;
  line-height: 45px;
}
.chat-window .chat-header span.close{
  opacity: 1;
  position: absolute!important;
  display: block!important;
  top: calc(50% - (0.5em / 2));
  right: calc(1.5em - (0.5em / 2));
  width: 0.5em!important;
  height: 0.5em!important;
  transition-delay: 250ms!important;
  transition: all ease 350ms!important;
}
.chat-window .chat-header span.close:before{
  content: "";
  display: block!important;
  position: absolute!important;
  top: calc(50% - (1px / 2));
  left: -11%!important;
  width: 120%!important;
  height: 2px!important;
  background: #fff!important;
  transform-origin: 50% 50%!important;
  border-radius: 20px!important;
}
.chat-window .chat-header span.close:after{
  opacity:0!important;
}
.docked .chat-header span.close:after{
  opacity:1!important;
  content: ""!important;
  display: block!important;
  position: absolute!important;
  top: calc(50% - (1px / 2));
  left: -11%!important;
  width: 120%!important;
  height: 2px!important;
  background: #fff!important;
  transform-origin: 50% 50%!important;
  border-radius: 20px!important;
}
.chat-window .chat-header span.close:before {
  transform: rotate(0deg)!important;
}
.chat-window .chat-header span.close:after {
  transform: rotate(90deg)!important;
}
.play-btn a i{
  color: #000!important;
  font-size: 10px!important;
  border-radius: 50px!important;
  background-color: #fff!important;
  padding: 5px 4px 4px 6px!important;
  height: 20px!important;
  width: 20px!important;
  text-align: center!important;
}
.chat-window .chat-body {
  height: calc(420px - ( 45px + 70px));
  border: 5px solid #f6911d!important;
  background: #fff!important;
  border-top: 0!important;
  border-bottom: 0!important;
  position: relative!important;
  padding: 20px!important;
}
.chat-window .chat-footer {
  height: 70px!important;
  border: 1px solid #263238!important;
  border-top: 0!important;
  border-bottom: 0!important;
  margin-top: -30px!important;
}
.chat-window .chat-footer .progress-indicator {
  opacity: 1!important;
  background: rgba(255, 255, 255, 0.9)!important;
  height: 30px!important;
  text-align: center!important;
  font-size: 0.7em!important;
  font-weight: 300!important;
  line-height: 30px!important;
  position: relative!important;
  z-index: 4!important;
  transition: all ease 150ms!important;
}
.chat-window .chat-footer .form-area {
  height: 40px!important;
  position: relative!important;
}
.chat-window .chat-footer .form-area input {
  height: 40px!important;
  width: calc(100% - (.7em + 2.5em + 2px))!important;
  border: 0!important;
  padding: 0 0.7em!important;
  font-size: 1em!important;
  border-top: 1px dotted #607d8b!important;
  outline: none!important;
  font-family: "Open Sans", sans-serif!important;
}
.note{
  border-top: none!important;
  border-left: none!important;
  border-right: none!important;
  border-radius: 0px!important;
}
.note-checkbox{
  margin-top: 15px!important;
  margin-bottom: 10px!important;
}
.note-submit{
  background: #1A73E8!important;
  color: #fff!important;
  font-weight: 500!important;
  font-size: 14px!important;
  padding: 5px 20px!important;
}
.hide {
  opacity: 0 !important;
}

    </style>
@endpush

@push('after-scripts')

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript">
        var hours = 0;
        var mins = 0;
        var seconds = 0;
        $('#starttime').click(function() {
            $('#starttime').hide();
             $('#stop').show();
             $('#start').hide();
             var dt = new Date();
             var hours = dt.getHours()
            minute = dt.getMinutes();
            hours = (hours % 12) || 12;
    // alert("Time is " + hours + ":" + minute + ":" + dt.getSeconds());
             var time = hours + ":" + minute + ":" + dt.getSeconds();
            //alert(time);
            startTimer();
            setCookie("starttimer", time, 30);
            //$.cookie("starttimer", null, { path: '/' });
           
        });
        $('#start').click(function() {
            startTimer();
             $('#stop').show();
              $('#start').hide();
            
        });
        $('#stop').click(function() {
            clearTimeout(timex);
            $('#start').show();
            $('#stop').hide();
        });



        function startTimer() {
            timex = setTimeout(function() {
                seconds++;
                if (seconds > 59) {
                    seconds = 0;
                    mins++;
                    if (mins > 59) {
                        mins = 0;
                        hours++;
                        if (hours < 10) {
                            $("#hours").text('0' + hours + ':')
                        } else $("#hours").text(hours + ':');
                    }

                    if (mins < 10) {
                        $("#mins").text('0' + mins + ':');
                    } else $("#mins").text(mins + ':');
                }
                if (seconds < 10) {
                    $("#seconds").text('0' + seconds);
                } else {
                    $("#seconds").text(seconds);
                }
                startTimer();
            }, 1000);
        }
        var usertype = '<?php echo $user_role; ?>';
        //    alert(usertype);
        $.ajax({
            url: '{{ route("backend.$module_name.index_data") }}',
            //context: document.body,
            dataType: 'json',
            data: {
                usertype: usertype
            },
            success: function(response) {
                //var show_btn = '<a href="tasks/'+response[0][i]['id']+'" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Milestone"><i class="fas fa-eye"></i></a>'
                //    print_r(response);

                //    die();
                
                for (var i = 0; i < response[0].length; i++) {
                    // console.log(response[i]);
                   
                    var dropdown_html = '';
                //     if(usertype != 'manager' && usertype != 'super admin')
                // {
                    if (response[0][i]['task_status'] != '2') {
                        var emp = '<?php if(isset($emp) && !empty($emp)){ echo $emp[0]->name; } ?>';
                        // var emp_id = '<?php if(isset($emp) && !empty($emp)){ echo $emp[0]->id; } ?>';
                        
                        if ( response[0][i]['assign_to'] == emp || response[0][i]['assign_to'] == emp) {
                            dropdown_html += '<div class="myMenu">';
                            dropdown_html += '<ul class="dropDownMenu">';
                            dropdown_html +=
                                '<li class="has-children"><a href="javascript:void(0);"  class="commentsToggle"><i class="fas fa-angle-double-down"></i></a>';
                            dropdown_html += '<ul class="open">';
                            if (response[0][i]['task_status'] != '2' && response[0][i]['task_status'] != '1') {
                                dropdown_html +=
                                    '<li><a href="javascript:void(0);" class="btn-start-task"  id="hide" data-status="new" data-task_id="' +
                                    response[0][i]['id'] + '" >Start Task</a></li>';
                            }
                            if (response[0][i]['task_status'] != '2' && response[0][i]['task_status'] != '0' &&
                                response[0][i]['task_status'] != '3') {
                                dropdown_html +=
                                    '<li><a href="javascript:void(0);" class="btn-start-timer" data-task_id="' +
                                    response[0]
                                    [i]['id'] + '" >Start Timer</a></li>';
                            }


                            // var task_id = response[0][i]['id'];
                            // var employee_id = response[0][i]['employee_id'];
                            if (response[0][i]['add_right'] && response[0][i]['task_status'] != '2') {
                                dropdown_html +=
                                    '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" class="tfAddtimelog" data-task_id="' +
                                    response[0]
                                    [i]['id'] + '" data-task_name="' + response[0]
                                    [i]['task_name'] + '" >Add Timelog</a></li>';
                            }
                            dropdown_html +=
                                '<li><a href="javascript:void(0);" class="btn-start-task" data-status="closed" data-task_id="' +
                                response[0][i]['id'] + '" >Closed</a></li>';
                            dropdown_html += '</ul></li></ul></div>';
                        }
                    }
                // }

                    // task priority
                    if (typeof(response[0][i]['task_priority']) != "undefined" && response[0][i][
                            'task_priority'
                        ] !== null && response[0][i]['task_priority'] == '1') {
                        response[0][i]['task_priority'] = 'High';
                    } else if (typeof(response[0][i]['task_priority']) != "undefined" && response[0][i][
                            'task_priority'
                        ] !== null && response[0][i]['task_priority'] == '2') {
                        response[0][i]['task_priority'] = 'Medium';
                    } else if (typeof(response[0][i]['task_priority']) != "undefined" && response[0][i][
                            'task_priority'
                        ] !== null && response[0][i]['task_priority'] == '3') {
                        response[0][i]['task_priority'] = 'Low';
                    }

                    // task task_status
                    if (typeof(response[0][i]['task_status']) != "undefined" && response[0][i][
                            'task_status'
                        ] !== null && response[0][i]['task_status'] == '0') {
                        response[0][i]['task_status'] = 'New';
                    } else if (typeof(response[0][i]['task_status']) != "undefined" && response[0][i][
                            'task_status'
                        ] !== null && response[0][i]['task_status'] == '1') {
                        response[0][i]['task_status'] = 'In Progress';
                    } else if (typeof(response[0][i]['task_status']) != "undefined" && response[0][i][
                            'task_status'
                        ] !== null && response[0][i]['task_status'] == '2') {
                        response[0][i]['task_status'] = 'Closed';
                    } else if (typeof(response[0][i]['task_status']) != "undefined" && response[0][i][
                            'task_status'
                        ] !== null && response[0][i]['task_status'] == '3') {
                        response[0][i]['task_status'] = 'ReOpen';
                    }
                    var spend_hours;
                    if (response[0][i]['spend_hours'] == null) {
                        spend_hours = '00:00:00';
                    } else {
                        spend_hours = response[0][i]['spend_hours'];
                    }
                    var assignto = '';
                    //alert(usertype);
                    if (usertype != 'user') {
                        assignto = '<td>' + response[0][i]['assign_to'] + '</td>';
                    }
                    var assignby = '';
                    if (usertype != 'manager') {
                        assignby = '<td>' + response[0][i]['assign_by'] + '</td>';
                    }
                    var spend_hours_str =spend_hours;
                var spendhours  = spend_hours_str.split(":");
                if(spendhours[1] > 0) {
                  var hourss = spendhours[1]+ ' Min';
                } else if (spendhours[0] > 0) {
                    var hourss  = spendhours[0]+ 'Hrs ' +spendhours[1]+ 'Min';
                } else {
                   // var hourss = '' spendhours[0]+ 'hrs ' +spendhours[1]+ 'Min' +spendhours[2]+'Sec'
                   var hourss = '0 Hrs';
                }
                    var pro_end_dt = moment(response[0][i]['end_date']).format('D-MMM-YYYY');
                    $('#taskbidders').append('<tr class="task_row_' + response[0][i]['id'] + '"><td>' + response[0][i]['project_name'] + '</td><td>' + response[
                            0][i]['milestone_name'] + '</td><td>' + response[0][i]['task_name'] +
                        '</td><td>' + response[0][i]['task_priority'] +
                        '</td>' + assignby + '<td>' + hourss + '</td>' +
                        assignto + '<td>' +pro_end_dt+ '</td><td><span class="spnTaskStatus-' + response[0][i]['id'] + '">' +
                        response[0][i]['task_status'] + '</span></td><td class="st_time">' +
                        '<a href="tasks/' + response[0][i]['id'] +
                        '/edit" class="btn btn-primary btn-sm "  title="Edit Task"><i class="fas fa-edit"></i></a><a href="tasks/' +
                        response[0][i]['id'] +
                        '" class="btn btn-success btn-sm "  title="Show Task"><i class="fas fa-eye"></i></a>'+ dropdown_html + '</td></tr>'
                    );
                }
                
                $('.myMenu ul li.has-children > a').click(function() {
                    // $(this).siblings(".fas fa-angle-double-down").toggleClass('hidden');
                    $(".open").slideUp("fast");
                    if ($(this).next('ul').hasClass('selected')) {
                        $(this).next('ul').css('display', 'none').removeClass('selected');
                    } else {
                        $('#taskbidders').find('ul.selected').css('display', 'none').removeClass(
                            'selected');
                        $(this).parent().siblings().find('ul').slideUp(300);
                        $(this).next('ul').stop(true, false, true).slideToggle(300);
                        $(this).next('ul').addClass('selected');

                    }
                    return false;
                });
                $(document).on("click", function(event) {
                    if (!$(event.target).closest(".has-children").length) {
                        $(".open").slideUp("fast");
                        $('#taskbidders').find('ul.selected').css('display', 'none').removeClass(
                            'selected');
                    }
                });
                function openpopup()
                {
                $('.btn-start-timer').on('click', function()
                 {
                    $('.txtTaskid').val($(this).data('task_id'));
                   $('.chat-window').toggleClass('docked');
                   var taskid = $(this).data('task_id');
                   var currentRow = $('.task_row_' + taskid);
                   var col1=currentRow.find("td:eq(0)").text();
                   $('.txtTaskname').val(col1);
                   $('.chat-window').css('display','block');
                  // setCookie("taskid", taskid, 1);
                    
                });
                 }                 
                 openpopup();
                $('.btn-start-task').on('click', function() {
                     var taskid = $(this).data('task_id');
                    var task_status = $(this).data('status');
                    $(this).addClass('active-timer' + taskid);
                    $.ajax({
                        url: '{{ route("backend.$module_name.change_task_status") }}',
                        //context: document.body,
                        dataType: 'json',
                        data: {
                            task_id: taskid,
                            task_status: task_status
                        },
                        // success: function(response) {

                        //     if (response.readyState === 4 && response.status === 200) {
                        //         if (task_status == 'closed') {
                        //             $('.spnTaskStatus-' + taskid).html('Closed');
                        //         } else if (task_status == 'new') {
                        //             $('.spnTaskStatus-' + taskid).html('In Progress');
                        //         }

                        //         alert('status changed successfully.');
                        //        

                        //         $('.active-timer'+taskid).text('Start Timer');
                        //        // $('.active-timer'+taskid).data('status').remove();
                        //         $('.active-timer'+taskid).addClass('btn-start-timer').removeClass('btn-start-task');
                        //     } else {
                        //         alert('status not changed successfully.');
                        //     }
                        // },
                        error: function(response) {
                            //         $(function() {
                            //   $( "#dialog" ).dialog();
                            //   });

                            if (response.readyState === 4 && response.status === 200) {
                                //alert('log added successfully.');

                                //$('.active-timer'+taskid).text('Start Timer');
                                //$('.active-timer'+taskid).removeAttr('data-status');
                                //  $('.active-timer'+taskid).addClass('btn-start-timer').removeClass('btn-start-task');
                                //$('.timer').show();
                                $('.txtTaskid').val(taskid);
                                $('.active-timer'+taskid).text('Start Timer');
                                
                                if (task_status == 'closed') {
                                    $('.spnTaskStatus-' + taskid).html('Closed');
                                    $('.active-timer' + taskid).parent().parent('ul.open')
                                        .css('display', 'none');
                                    $('.active-timer' + taskid).parent().parent('ul.open')
                                        .prev().css('display', 'none');

                                } else if (task_status == 'new') {
                                    $('.spnTaskStatus-' + taskid).html('In Progress');
                                    $('.active-timer' + taskid).text('Start Timer');
                                    $('.active-timer' + taskid).addClass('btn-start-timer')
                                        .removeClass('btn-start-task').removeAttr(
                                            'data-status');
                                            openpopup();
                                }
                                else{
                                    $('#alert-message').delay(1000).fadeOut("fast").show();
                                }
                               
                            }
                             else {

                                $('#alert-message').show();
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                location.reload();


                            }

                        }

                    });

                });



                $('#datatable').DataTable({
                    autoWidth: true,
                    responsive: true,
                    order:[[1,"desc"]]
                });

                $('.tfAddtimelog').on('click', function() {
                    $('.tfTaskid').val($(this).data('task_id'));
                    $('.tfTaskname').val($(this).data('task_name'));
                });
            }
        });

        var t = [0, 0, 0, 0, 0, 0, 0, 1];
        jQuery('.submitLog').on('click', function() {
        //    alert('');
            var error = 0;

            $(".removemsg").remove();
            if ($.trim($("#txtTimeLog").val()) == "") {
                $(".txtTimeLog").after(
                    "<div id='removemsg' class='validation removemsg' style='color:red;'>Please Enter Logname</div>"
                );
                error = 1;
            }
            if ($.trim($("#txtareaLogdesc").val()) == "") {
                $(".txtareaLogdesc").after(
                    "<div id='removemsg' class='validation removemsg' style='color:red;'>Please Enter Description</div>"
                );
                error = 1;
            }
            if (error == 1) {
                return false;
            } else {
                $('#img').show();
            }
            //console.log('submit_record :- spend_hours = '+t[6].value+' start_time = '+ format(t[1]-t[0]) + ' end_time = '+ format(t[3]) + ' logdesc = '+$('.txtareaLogdesc').val() + ' taskid = '+$('.txtTaskid').val());
            var hours = $("#hours").text();
            var seconds = $("#seconds").text();
            var mins = $("#mins").text();
            var newhours = hours + '' + mins + '' + seconds;
            //var c = parseFloat(seconds) + parseFloat(mins)+parseFloat(hours);
            var taskid = $('.txtTaskid').val();
            var starttimer = getCookie('starttimer');
                start_time = starttimer;

                var dt1 = new Date();
             var hours1 = dt1.getHours()
            minute1 = dt1.getMinutes();
            hours1 = (hours1 % 12) || 12;
             var time1 = hours1 + ":" + minute1 + ":" + dt1.getSeconds();
                end_time = time1;
                logname = $('.txtTimeLog').val();
                logdesc = $('.txtareaLogdesc').val();
            $.ajax({
                url: '{{ route("backend.$module_name.submit_log_data") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    
                    task_id: taskid,
                    spend_hours: newhours,
                    start_time: start_time,
                    end_time: end_time,
                    logname: logname,
                    logdesc: logdesc
                },

                success: function(response) {

                    if (response.readyState === 4 && response.status === 200) {
                        //alert('log added successfully.');
                        $('.lblResponse').append('log added successfully.');

                        $('.lblResponse').css('color', '#0F0');
                        // r();
                        location.reload();
                    } else {
                        $('.lblResponse').css('color', '#00F');
                        $('.lblResponse').append('log not added.');
                    }
                },
                error: function(response) {
                    if (response.readyState === 4 && response.status === 200) {
                        
                        $('.lblResponse').append('log added successfully.');
                        $('.lblResponse').css('color', '#0F0');
                        //r();
                         location.reload();
                    } else {
                        
                        $('.lblResponse').css('color', '#00F');
                        $('.lblResponse').append('log not added.');
                    }
                }
            });
           

        });
        
        // $.cookie('taskid', null, { path: '/' });

        /* function r() {
             if (t[2]) ss();
             t[4] = t[3] = t[2] = t[1] = t[0] = 0;
             disp();
             document.getElementById('lap').innerHTML = '';
             t[7] = 1;
         }*/


        function format(ms) {
            // used to do a substr, but whoops, different browsers, different formats
            // so now, this ugly regex finds the time-of-day bit alone
            var d = new Date(ms + t[5]).toString()
                .replace(/.*([0-9][0-9]:[0-9][0-9]:[0-9][0-9]).*/, '$1');
            var x = String(ms % 1000);
            while (x.length < 3) x = '0' + x;
            d += '.' + x;
            return d;
        }

        // function remote() {
        // window.open(
        // document.location, '_blank', 'width=700,height=350'
        // );
        // return false;
        // }
        // function load() {
        //     t[5] = new Date(1970, 1, 1, 0, 0, 0, 0).valueOf();
        //     t[6] = document.getElementById('disp');

        //     // disp();

        //     /*if (!window.opener && window==window.top) {
        //     document.getElementById('remote').style.visibility='visible';
        //     }*/
        // }

        $(document).ready(function() {
            $('#timelogform').submit(function(event) {
                var formData = {
                    task_id: $('#tfTaskid').val(),
                    name: $('#name').val(),
                    log_date: $('#log_date').val(),
                    start_time: $('#start_time').val(),
                    end_time: $('#end_time').val(),
                    spend_hours: $('#spend_hours').val(),
                    description: $('#description').val(),
                }

                $.ajax({
                    url: '{{ route("backend.$module_name.submit_manual_log") }}',
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (data) {
                        alert('Log has been added successfully.');
                    } else {
                        alert('Log has not added.');
                    }
                    window.location.href = $(location).attr("href");
                });

                event.preventDefault();
            });
        });
        $(function(){
    $('.close,.btn-start-timer').click(function(){
      $(this).toggleClass('offline');
      $(this).toggleClass('online');
      $('.chat-window').toggleClass('docked');
    });   
    setInterval(function(){
      $('.progress-indicator').toggleClass('hide');
    },7846);
  });

  function setCookie(cname, cvalue, exdays) {

const d = new Date();

d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

let expires = "expires=" + d.toUTCString();

document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

//location.reload();

}
function getCookie(cname) {

let name = cname + "=";

let decodedCookie = decodeURIComponent(document.cookie);

let ca = decodedCookie.split(';');

for (let i = 0; i < ca.length; i++) {

    let c = ca[i];

    while (c.charAt(0) == ' ') {

        c = c.substring(1);

    }

    if (c.indexOf(name) == 0) {

        return c.substring(name.length, c.length);

    }

}

return "";

}
  
    </script>
@endpush