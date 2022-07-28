<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

$user = Auth::user()->id;
$role_id = DB::select('select `role_id` from `model_has_roles` where `model_id` = ' . $user);
$role_name = DB::select('select `name` from `roles` where `id` = ' . $role_id[0]->role_id);
$emp = DB::select('select `id` from `employees` where `user_id` = ' . $user);
// if(isset($user) && !empty($user) && $role_name[0]->name == 'user')
// {
//     //  var_dump($user);
//     // die();
// }
$user_role = $role_name[0]->name;
// echo $a;
// die;
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
                        <i class="{{ $module_icon }}"></i> {{ $module_title }}
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
                                <button id="btnGroupToolbar" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
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
                        aria-hidden="true">×</button>
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
                                    Task Name
                                </th>
                                <th>
                                    Milestone
                                </th>
                                <th>
                                    Project Name
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
                                <th class="text-right">
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
                        <div class="timer" id="dialog">
                            <div id="main">
                                <button class="open-button" onclick="openForm()"> <span style="float:left;">00:00:00 &nbsp; </span> <span> <i class="fa fa-angle-down down-arrow" aria-hidden="true"></i> </span>        </button>

                                <div class="chat-popup" id="myForm">

                                    <form action="/action_page.php" class="form-container">
                                      <button type="button" class="btn cancel" onclick="closeForm()">  <span style="float:left;">00:00:00 &nbsp; <i class="fa fa-play" aria-hidden="true"></i> &nbsp; <i class="fa fa-pause" aria-hidden="true"></i>       </span> <span> <i class="fa fa-angle-down down-arrow" aria-hidden="true"></i> </span>    </button>
                                  <div class="wrapper">
                                      <label for="msg"><b>Project</b></label>
                                      <select class="form-control valid" name="service" required="" aria-invalid="false">
                                                                     
                                                                      <option value="Mobile App Development"> PMS </option>
                                                                      <option value="BlockChain Development"> Mobile </option>
                                                                    
                                                                      <option value="Other"> Other </option>
                                                                  </select>
                                  <label for="msg"><b>Task</b></label>
                                      <select class="form-control valid" name="service" required="" aria-invalid="false">
                                                                     
                                                                      <option value="Mobile App Development"> Title </option>
                                                                      <option value="BlockChain Development"> Mobile2 </option>
                                                                    
                                                                      <option value="Other"> Other </option>
                                                                  </select>
                                                                  
                                                      <div>	<label for="msg"><b>Note</b></label>
                                      <hr>
                                      <label class="billable">
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>Is it Billable?
                                  </label>						
                                          </div>			
                                          <br>
                                     <div> <button type="submit" class="btn2">Start Timer</button><button type="submit" class="btn2">Cancel</button> </div>
                                  <br><br><br>
                                  
                                     </div>
                                    </form>
                                  </div>
                               
                            </div>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

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

        body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}
select.form-control.valid {
    border: 1px solid #ddd;
    width: 100%;
    padding: 15px 11px;
    margin-bottom: 10px;
}
/* Button used to open the chat form - fixed at the bottom of the page */
.open-button {
    background-color: orange !important;
    color: white !important;
    border: none ;
    cursor: pointer ;
    position: fixed !important;
    bottom: 0px !important;
    text-align: left !important;
    width: 270px !important;
    padding: 16px 20px !important;
    border-radius: 0px !important;
}

/* The popup chat - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  left: 270px;
  border: 7px solid orange;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  /*padding: 5px;*/
  background-color: white;
}

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 8px;
  margin: 5px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 20px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.form-container .btn {
    background-color: orange !important;
    color: white!important;
    padding: 16px 20px!important;
    border: none!important;
    cursor: pointer!important;
    width: 100%!important;
    /* margin-bottom: 10px; */
    /* opacity: 0.8; */
    text-align: left!important;
    border-radius:0px !important; 
}
.btn2 {
    background-color: blue !important;
    color: white!important;
    padding: 16px 20px!important;
    border: none!important;
    cursor: pointer!important;
    width: 47%!important;
    margin-right: 7px!important;
    margin-bottom: 10px!important;
    opacity: 0.8!important;
    text-align: center!important;
    float: right!important;
    border-radius:0px !important; 
}
/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: orange !important;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
label.billable {
    font-size: 14px;
}
.wrapper{padding:10px;}
.down-arrow {
    margin-left: 155px !important;
}

       
    </style>
@endpush

@push('after-scripts')
    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>



    <script type="text/javascript">
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
                    if (response[0][i]['task_status'] != '2') {
                        dropdown_html += '<div class="myMenu">';
                        dropdown_html += '<ul class="dropDownMenu">';
                        dropdown_html +=
                            '<li class="has-children"><a href="javascript:void(0);"><i class="fas fa-angle-double-down"></i></a>';
                        dropdown_html += '<ul class="open">';
                        if (response[0][i]['task_status'] != '2' && response[0][i]['task_status'] != '1') {
                            dropdown_html +=
                                '<li><a href="javascript:void(0);" class="btn-start-task" data-status="new" data-task_id="' +
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
                            '<li><a href="javascript:void(0);" class="btn-start-task " data-status="closed" data-task_id="' +
                            response[0][i]['id'] + '" >Closed</a></li>';
                        dropdown_html += '</ul></li></ul></div>';
                    }

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
                    $('#taskbidders').append('<tr><td>' + response[0][i]['task_name'] + '</td><td>' + response[
                            0][i]['milestone_name'] + '</td><td>' + response[0][i]['project_name'] +
                        '</td><td>' + response[0][i]['task_priority'] +
                        '</td>' + assignby + '<td>' + spend_hours + '</td>' +
                        assignto + '<td>' + response[0][i][
                            'end_date'
                        ] + '</td><td><span class="spnTaskStatus-' + response[0][i]['id'] + '">' +
                        response[0][i]['task_status'] + '</span></td><td>' + dropdown_html +
                        '<a href="tasks/' + response[0][i]['id'] +
                        '/edit" class="btn btn-primary btn-sm "  title="Edit Task"><i class="fas fa-edit"></i></a><a href="tasks/' +
                        response[0][i]['id'] +
                        '" class="btn btn-success btn-sm "  title="Show Task"><i class="fas fa-eye"></i></a></td></tr>'
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
                 $('.btn-start-timer').on('click', function() {
                                    //alert("123 hello");
                                    //$(this).parent().parent().parent().parent().parent().parent().parent().css( "background-color", "greay" );
                                    $('.timer').toggle();
                                    $('.txtTaskid').val($(this).data('task_id'));
                                    $('.tfTaskname').val($(this).data('task_name'));
                                   // alert("hiii");
                                });
               
                $('.btn-start-task').on('click', function() 
                {
                   
                    var taskid = $(this).data('task_id');
                    //var taskname = $(this).data('task_name');
                    var task_status = $(this).data('status');
                    $(this).addClass('active-timer' + taskid);
                    $.ajax({
                        url: '{{ route("backend.$module_name.change_task_status") }}',
                        //context: document.body,
                        dataType: 'json',
                        data: {
                            task_id: taskid,
                            task_status: task_status,
                           // taskname :taskname
                        },
                        // success: function(response) {

                        //     if (response.readyState === 4 && response.status === 200) {
                        //         if (task_status == 'closed') {
                        //             $('.spnTaskStatus-' + taskid).html('Closed');
                        //         } else if (task_status == 'new') {
                        //             $('.spnTaskStatus-' + taskid).html('In Progress');
                        //         }

                        //         alert('status changed successfully.');
                               

                        //         $('.active-timer'+taskid).text('Start Timer');
                        //        // $('.active-timer'+taskid).data('status').remove();
                        //         $('.active-timer'+taskid).addClass('btn-start-timer').removeClass('btn-start-task');
                        //     } else {
                        //         alert('status not changed successfully.');
                        //     }
                        // },
                        error: function(response) {
                            if (response.readyState === 4 && response.status === 200) {
                                $('.txtTaskid').val(taskid);
                                if (task_status == 'closed') 
                                {
                                
                                    $('.spnTaskStatus-' + taskid).html('Closed');
                                    $('.active-timer' + taskid).parent().parent('ul.open').css('display','none');
                                    $('.active-timer' + taskid).parent().parent('ul.open').prev().css('display','none');
                                   

                                } 
                                else if (task_status == 'new') 
                                {
                                    
                                    $('.spnTaskStatus-' + taskid).html('In Progress');
                                    $('.active-timer' + taskid).text('Start Timer');
                                    $('.active-timer' + taskid).addClass('btn-start-timer').removeClass('btn-start-task').removeAttr('data-status');
                                   
                                }
                                else
                                {
                                $('#alert-message').delay(1000).fadeOut("fast").show();
                                //$("html, body").animate({ scrollTop: 0 }, "slow");
                                //location.reload();    
                                }
                            } 
                            else
                             {

                                $('#alert-message').show();
                                $("html, body").animate({
                                    scrollTop: 0
                                }, "slow");
                                location.reload();


                            }

                        }

                    });

                });
               



                // $('#datatable').DataTable({
                //     autoWidth: true,
                //     responsive: true,
                // });

                $('.tfAddtimelog').on('click', function() {
                    $('.tfTaskid').val($(this).data('task_id'));
                    $('.tfTaskname').val($(this).data('task_name'));
                });
            }
        });

        var t = [0, 0, 0, 0, 0, 0, 0, 1];

        // /* function ss() {
        //      t[t[2]] = (new Date()).valueOf();
        //      t[2] = 1 - t[2];

        //      if (0 == t[2]) {
        //          //console.log('1s');
        //          clearInterval(t[4]);
        //          t[3] += t[1] - t[0];
        //          var row = document.createElement('tr');
        //          var td = document.createElement('td');
        //          td.innerHTML = (t[7]++);
        //          row.appendChild(td);
        //          td = document.createElement('td');
        //          td.innerHTML = format(t[1] - t[0]);
        //          row.appendChild(td);
        //          td = document.createElement('td');
        //          td.innerHTML = format(t[3]);
        //          row.appendChild(td);
        //          document.getElementById('lap').appendChild(row);
        //          t[4] = t[1] = t[0] = 0;
        //          var submit_record = true;
        //          disp(submit_record);
        //      } else {
        //          //console.log('2s');
        //          t[4] = setInterval(disp, 43);
        //      }
        //  }*/

        // function disp(submit_record = '') {
        //     //console.log('3d');
        //     if (t[2]) t[1] = (new Date()).valueOf();
        //     t[6].value = format(t[3] + t[1] - t[0]);
        //     //console.log(t[6].value);
        //     /*if(submit_record){
        //         console.log('submit_record :- spend_hours = '+t[6].value+' start_time = '+ format(t[1]-t[0]) + ' end_time = '+ format(t[3]));
        //     }*/
        // }


        jQuery('.submitLog').on('click', function() {


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

                // evt.preventDefault();
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
            var taskid = $('.txtTaskid').val(),
                //     spend_hours = t[6].value,
                start_time = format(t[1] - t[0]),
                end_time = format(t[3]),
                logname = $('.txtTimeLog').val(),
                logdesc = $('.txtareaLogdesc').val();

            //     var a = spend_hours.split(':'); // split it at the colons
            //     console.log(a);
            //     // minutes are worth 60 seconds. Hours are worth 60 minutes.
            //     var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
            //     var hours = (seconds / 60 / 60);
            //    console.log(hours);
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
                        //alert('log added successfully.');
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
        function load() {
            t[5] = new Date(1970, 1, 1, 0, 0, 0, 0).valueOf();
            t[6] = document.getElementById('disp');

            // disp();

            /*if (!window.opener && window==window.top) {
            document.getElementById('remote').style.visibility='visible';
            }*/
        }

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
    </script>
    <script>
        function openForm() {
          document.getElementById("myForm").style.display = "block";
        }
        
        function closeForm() {
          document.getElementById("myForm").style.display = "none";
        }
        </script>

@endpush
