@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ $module_title }}</x-backend-breadcrumb-item>
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
                    title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}" />

                <div class="btn-group" role="group" aria-label="Toolbar button groups">
                    <div class="btn-group" role="group">
                        <button id="btnGroupToolbar" type="button" class="btn btn-secondary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                            <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
                            Priority
                        </th>
                        <th>
                            Assigned By
                        </th>
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
                <div class="timer">
                    <div id="main">
                        <button type="button" onclick="ss()" onfocus="this.blur()">Start / Stop</button>
                        <input type="text" id="disp">
                        <!-- <button type="button" onclick="r()" onfocus="this.blur()">Reset</button> -->
                    </div>
                    <table border="1" class="timer-table">
                        <tbody>
                            <tr>
                                <th>No</th>

                                <th>Start Time</th>

                                <th>Total Hours</th>
                            </tr>
                        </tbody>
                        <tbody id="lap">
                            </tr>
                        </tbody>
                    </table>

                    <textarea name='txtareaLogdesc' id='txtareaLogdesc' class='txtareaLogdesc form-control'
                        placeholder="Enter work description"></textarea>
                    <input type="hidden" name="txtTaskid" id="txtTaskid" class="txtTaskid">
                    <button type="button" class="submitLog">Submit Log</button>
                    <span class="lblResponse"></span>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="float-right">

            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
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
</style>
@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript">
    // $('#datatable').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     autoWidth: true,
    //     responsive: true,
    //     ajax: '{{ route("backend.$module_name.index_data") }}',
    //     columns: [
    //         {data: 'id', name: 'id'},
    //         {data: 'name', name: 'name'},
    //         {data: 'milestone_id', name: 'milestone'},
    //         {data: 'task_priority', name: 'task_priority'},
    //         {data: 'assign_by', name: 'assign_by'},
    //         {data: 'end_date', name: 'end_date'},
    //         {data: 'status', name: 'status'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false}
    //     ]
    // });

    $.ajax({
        url: '{{ route("backend.$module_name.index_data") }}',
        //context: document.body,
        dataType: 'json',
        success: function (response) {
            //var show_btn = '<a href="tasks/'+response[0][i]['id']+'" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Milestone"><i class="fas fa-eye"></i></a>'
            //alert(response);



            for (var i = 0; i < response[0].length; i++) {
                console.log(response[i]);
                var dropdown_html = '<div class="myMenu">';
                dropdown_html += '<ul class="dropDownMenu">';
                dropdown_html +=
                    '<li class="has-children"><a href="#"><i class="fas fa-angle-double-down"></i></a>';
                dropdown_html += '<ul>';
                dropdown_html += '<li><a href="javascript:void(0);" class="btn-start-task" data-status="new" data-task_id="' +
                    response[0][i]['id'] + '" >Start Task</a></li>';
                dropdown_html +=
                    '<li><a href="javascript:void(0);" class="btn-start-timer" data-task_id="' + response[0]
                    [i]['id'] + '" >Start Timer</a></li>';

                // var task_id = response[0][i]['id'];
                // var employee_id = response[0][i]['employee_id'];
                if(response[0][i]['add_right']){
                    dropdown_html +=
                    '<li><a href="timelogs/create" class="" data-task_id="' + response[0]
                    [i]['id'] + '" >Add Timelog</a></li>';
                }
                dropdown_html += '<li><a href="javascript:void(0);" class="btn-start-task" data-status="closed" data-task_id="' +
                    response[0][i]['id'] + '" >Closed</a></li>';
                dropdown_html += '</ul></li></ul></div>';

                // task priority
                if (typeof (response[0][i]['task_priority']) != "undefined" && response[0][i][
                        'task_priority'
                    ] !== null && response[0][i]['task_priority'] == '1') {
                    response[0][i]['task_priority'] = 'High';
                } else if (typeof (response[0][i]['task_priority']) != "undefined" && response[0][i][
                        'task_priority'
                    ] !== null && response[0][i]['task_priority'] == '2') {
                    response[0][i]['task_priority'] = 'Medium';
                } else if (typeof (response[0][i]['task_priority']) != "undefined" && response[0][i][
                        'task_priority'
                    ] !== null && response[0][i]['task_priority'] == '3') {
                    response[0][i]['task_priority'] = 'Low';
                }

                // task task_status
                if (typeof (response[0][i]['task_status']) != "undefined" && response[0][i][
                    'task_status'] !== null && response[0][i]['task_status'] == '0') {
                    response[0][i]['task_status'] = 'New';
                } else if (typeof (response[0][i]['task_status']) != "undefined" && response[0][i][
                        'task_status'
                    ] !== null && response[0][i]['task_status'] == '1') {
                    response[0][i]['task_status'] = 'In Progress';
                } else if (typeof (response[0][i]['task_status']) != "undefined" && response[0][i][
                        'task_status'
                    ] !== null && response[0][i]['task_status'] == '2') {
                    response[0][i]['task_status'] = 'Closed';
                } else if (typeof (response[0][i]['task_status']) != "undefined" && response[0][i][
                        'task_status'
                    ] !== null && response[0][i]['task_status'] == '3') {
                    response[0][i]['task_status'] = 'ReOpen';
                }

                $('#taskbidders').append('<tr><td>' + response[0][i]['task_name'] + '</td><td>' + response[
                        0][i]['milestone_name'] + '</td><td>' + response[0][i]['task_priority'] +
                    '</td><td>' + response[0][i]['assign_by'] + '</td><td>' + response[0][i][
                    'end_date'] + '</td><td><span class="spnTaskStatus-' + response[0][i]['id'] + '">' +
                    response[0][i]['task_status'] + '</span></td><td>' + dropdown_html +
                    '<a href="tasks/' + response[0][i]['id'] +
                    '/edit" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Edit Task"><i class="fas fa-edit"></i></a><a href="tasks/' +
                    response[0][i]['id'] +
                    '" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Task"><i class="fas fa-eye"></i></a></td></tr>'
                    );
            }

            $('.timer').hide();
            $('.btn-start-timer').on('click', function () {
                //alert();
                $('.timer').show();
                $('.txtTaskid').val($(this).data('task_id'));
            });

            $('.myMenu ul li.has-children > a').click(function () {
                $(this).parent().siblings().find('ul').slideUp(300);
                $(this).next('ul').stop(true, false, true).slideToggle(300);
                return false;
            });

            $('.btn-start-task').on('click', function () {
                var taskid = $(this).data('task_id');
                var task_status = $(this).data('status');
                $.ajax({
                    url: '{{ route("backend.$module_name.change_task_status") }}',
                    //context: document.body,
                    dataType: 'json',
                    data: {
                        task_id: taskid,
                        task_status: task_status
                    },
                    success: function (response) {
                        if (response.readyState === 4 && response.status === 200) {
                            $('.spnTaskStatus-' + taskid).html('In Progress');
                            alert('status changed successfully.');
                        } else {
                            alert('status not changed successfully.');
                        }
                    },
                    error: function (response) {
                        if (response.readyState === 4 && response.status === 200) {
                            //alert('log added successfully.');
                            alert('status changed successfully.');
                            $('.spnTaskStatus-' + taskid).html('In Progress');
                        } else {
                            alert('status not changed successfully.');
                        }
                    }
                });
            });
            $('#datatable').DataTable({
                autoWidth: true,
                responsive: true,
            });
        }
    });

    var t = [0, 0, 0, 0, 0, 0, 0, 1];

    function ss() {
        t[t[2]] = (new Date()).valueOf();
        t[2] = 1 - t[2];

        if (0 == t[2]) {
            //console.log('1s');
            clearInterval(t[4]);
            t[3] += t[1] - t[0];
            var row = document.createElement('tr');
            var td = document.createElement('td');
            td.innerHTML = (t[7]++);
            row.appendChild(td);
            td = document.createElement('td');
            td.innerHTML = format(t[1] - t[0]);
            row.appendChild(td);
            td = document.createElement('td');
            td.innerHTML = format(t[3]);
            row.appendChild(td);
            document.getElementById('lap').appendChild(row);
            t[4] = t[1] = t[0] = 0;
            var submit_record = true;
            disp(submit_record);
        } else {
            //console.log('2s');
            t[4] = setInterval(disp, 43);
        }
    }

    function disp(submit_record = '') {
        //console.log('3d');
        if (t[2]) t[1] = (new Date()).valueOf();
        t[6].value = format(t[3] + t[1] - t[0]);
        //console.log(t[6].value);
        /*if(submit_record){
            console.log('submit_record :- spend_hours = '+t[6].value+' start_time = '+ format(t[1]-t[0]) + ' end_time = '+ format(t[3]));
        }*/
    }

    jQuery('.submitLog').on('click', function () {
        //console.log('submit_record :- spend_hours = '+t[6].value+' start_time = '+ format(t[1]-t[0]) + ' end_time = '+ format(t[3]) + ' logdesc = '+$('.txtareaLogdesc').val() + ' taskid = '+$('.txtTaskid').val());
        var taskid = $('.txtTaskid').val(),
            spend_hours = t[6].value,
            start_time = format(t[1] - t[0]),
            end_time = format(t[3]),
            logdesc = $('.txtareaLogdesc').val();
        $.ajax({
            url: '{{ route("backend.$module_name.submit_log_data") }}',
            //context: document.body,
            dataType: 'json',
            data: {
                task_id: taskid,
                spend_hours: spend_hours,
                start_time: start_time,
                end_time: end_time,
                logdesc: logdesc
            },
            success: function (response) {
                if (response.readyState === 4 && response.status === 200) {
                    //alert('log added successfully.');
                    $('.lblResponse').append('log added successfully.');
                    $('.lblResponse').css('color', '#0F0');
                    r();
                    setInterval('location.reload()', 1000);
                } else {
                    $('.lblResponse').css('color', '#00F');
                    $('.lblResponse').append('log not added.');
                }
            },
            error: function (response) {
                if (response.readyState === 4 && response.status === 200) {
                    //alert('log added successfully.');
                    $('.lblResponse').append('log added successfully.');
                    $('.lblResponse').css('color', '#0F0');
                    r();
                    setInterval('location.reload()', 1000);
                } else {
                    $('.lblResponse').css('color', '#00F');
                    $('.lblResponse').append('log not added.');
                }
            }
        });
    });

    function r() {
        if (t[2]) ss();
        t[4] = t[3] = t[2] = t[1] = t[0] = 0;
        disp();
        document.getElementById('lap').innerHTML = '';
        t[7] = 1;
    }


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

        disp();

        /*if (!window.opener && window==window.top) {
        document.getElementById('remote').style.visibility='visible';
        }*/
    }
</script>
@endpush