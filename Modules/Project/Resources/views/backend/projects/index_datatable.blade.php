@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

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
                    <i class="{{ $module_icon }}"></i><i class="fas fa-paste c-sidebar-nav-icon"></i> {{ $module_title }}
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
                    <div class="btn-group" role="group">                        {{-- <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                            <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </div> --}}
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
                                #
                            </th> --}}
                        <th>
                            Project Name
                        </th>
                        <th>
                            Department Name
                        </th>
                        <th>
                            Priority
                        </th>
                        <th>
                            Start Date
                        </th>
                        <th>
                            End Date
                        </th>
                        <th>
                            Estimated Hours
                        </th>
                        <th>
                            Spend Hours
                        </th>
                        <th class="text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id='bidders'>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-7">
            <div class="float-left">

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

@push('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript">
    // $('#datatable').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     autoWidth: true,
    //     responsive: true,
    //     ajax: '{{ route("backend.$module_name.index_data") }}',
    //     columns: [
    //         // {data: 'id', name: 'id'},
    //         {data: 'name', name: 'name'},
    //         {data: 'project_type', name: 'project_type'},
    //         {data: 'priority', name: 'priority'},
    //         {data: 'estimated_hours', name: 'estimated_hours'},

    //         // {data: 'status', name: 'status'},
    //         {data: 'departments_id', name: 'departments_id'},
    //         {data: 'start_date', name: 'start_date'},
    //         {data: 'end_date', name: 'end_date'},

    //         // {data: 'created_by', name: 'created_by'},
    //         // {data: 'updated_at', name: 'updated_at'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false}
    //     ]
    // });

    $.ajax({
        url: '{{ route("backend.$module_name.index_data") }}',
        //context: document.body,
        dataType: 'json',
        success: function (response) {
            //alert(response);
            for (var i = 0; i < response[0].length; i++) {
                // console.log(response[0][i]);

                //  status
                if (typeof (response[0][i]['status']) != "undefined" && response[0][i]['status'] !== null &&
                    response[0][i]['status'] == '1') {
                    response[0][i]['status'] = 'Published';
                } else if (typeof (response[0][i]['status']) != "undefined" && response[0][i]['status'] !==
                    null && response[0][i]['status'] == '0') {
                    response[0][i]['status'] = 'Unpublished';
                } else if (typeof (response[0][i]['status']) != "undefined" && response[0][i]['status'] !==
                    null && response[0][i]['status'] == '2') {
                    response[0][i]['status'] = 'Draft';
                }

                //  priority
                if (typeof (response[0][i]['priority']) != "undefined" && response[0][i]['priority'] !==
                    null && response[0][i]['priority'] == '1') {
                    response[0][i]['priority'] = 'High';
                } else if (typeof (response[0][i]['priority']) != "undefined" && response[0][i][
                    'priority'] !== null && response[0][i]['priority'] == '2') {
                    response[0][i]['priority'] = 'Medium';
                } else if (typeof (response[0][i]['priority']) != "undefined" && response[0][i][
                    'priority'] !== null && response[0][i]['priority'] == '3') {
                    response[0][i]['priority'] = 'Low';
                }

                if(response[0][i]['spend_hours'])
                {
                    response[0][i]['spend_hours'];
                }
                else
                {
                    response[0][i]['spend_hours'] = '00';
                }
                
                var spend_hours_str =response[0][i]['spend_hours'];
                var spendhours  = spend_hours_str.split(":");
                if(spendhours[1] > 0) {
                  var hourss = spendhours[1]+ ' Min';
                } else if (spendhours[0] > 0) {
                    var hourss  = spendhours[0]+ 'Hrs ' +spendhours[1]+ 'Min';
                } else {
                   // var hourss = '' spendhours[0]+ 'Hrs ' +spendhours[1]+ 'Mins' +spendhours[2]+'Sec'
                   var hourss = '0 Hrs';
                }
                var pro_end_dt = moment(response[0][i]['end_date']).format('D-MMM-YYYY');
                var pro_start_dt =  moment(response[0][i]['start_date']).format('D-MMM-YYYY');
                $('#bidders').append('<tr><td>' + response[0][i][
                        'name'
                    ] + "</td>" + "<td>" + response[0][i][
                        'department_name'
                    ] + "</td><td>" + response[0][i][
                        'priority'
                    ] + "</td><td>" + pro_start_dt 
                     + "</td><td>" + pro_end_dt + '</td><td>' + response[0][i]['estimated_hours'] + " Hrs</td>"  
                    + '<td>' + hourss +
                     '</td><td> <a href="projects/' + response[0][i]["id"] +
                    '/edit" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Edit Project"> <i class = "fas fa-edit"> </i> </a> &nbsp; <a href="projects/' +
                    response[0][i]["id"] +
                    '" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Project"> <i class = "fas fa-eye"> </i> </a> </td>  </tr>'
                );

            }
            $('#datatable').DataTable({
                autoWidth: true,
                responsive: true,
            });
        }
    });
</script>
@endpush