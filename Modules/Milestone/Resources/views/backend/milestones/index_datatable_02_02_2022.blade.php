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
                                #
                            </th> --}}
                        <th>
                            Name
                        </th>

                        <th>
                            Start Date
                        </th>
                        <th>
                            End Date
                        </th>
                        <th>
                            Hours
                        </th>
                        <th>
                            Total Task
                        </th>
                        <th>
                            Milestone Weightage
                        </th>
                        <th>
                            Project Name
                        </th>
                        {{-- <th>
                                Updated At
                            </th> --}}

                        <th class="text-left">
                            Action
                        </th>
                    </tr>

                    <?php
                            // $$module_name = DB::select('SELECT milestones.* , COUNT(tasks.milestone_id) AS totaltask FROM `milestones` INNER JOIN tasks ON milestones.id = tasks.milestone_id GROUP BY milestones.id');
                            // $data = $$module_name;
                            ?>

                    {{-- @foreach ($data as $data)
                        <tr> --}}
                    {{-- <td> {{ $data->id }}</td>
                    <td> {{ $data->name }}</td>
                    <td> {{ $data->totaltask }}</td>
                    <td> {{ $data->start_date }}</td>
                    <td> {{ $data->end_date }}</td>
                    <td> {{ $data->hours }}</td>
                    <td> {{ $data->milestone_weightage }}</td>
                    <td> {{ $data->project_id }}</td>
                    <td> {{ $data->created_by }}</td> --}}
                    {{-- <td class="text-right"> 
                                <a href="{{ route("backend.$module_name.edit", $data->id) }}" class="btn btn-sm
                    btn-primary mt-1" data-toggle="tooltip" title="Edit {{ ucwords(Str::singular($module_name)) }}">
                    <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{ route("backend.$module_name.show", $data->id) }}" class='btn btn-sm btn-success mt-1'
                        data-toggle="tooltip" title="Show {{ ucwords(Str::singular($module_name)) }}">
                        <i class="fas fa-tv"></i>
                    </a>
                    </td> --}}
                    {{-- </tr>
                        @endforeach --}}

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
    //         {data: 'slug', name: 'slug'},
    //         {data: 'start_date', name: 'start_date'},
    //         {data: 'end_date', name: 'end_date'},
    //         {data: 'hours', name: 'hours'},
    //         {data: 'milestone_weightage', name: 'milestone_weightage'},
    //         {data: 'project_id', name: 'project_id'},
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
                console.log(response[0][i]);
                $('#bidders').append('<tr><td>' + response[0][i][
                        'name'
                    ] + "</td><td>" + response[0][i][
                        'start_date'
                    ] + '</td><td>' + response[0][i]['end_date'] + '</td><td>' + response[0][i][
                        'hours'
                    ] + "</td><td>" + response[0][i][
                        'total_task'
                    ] + '</td><td>' + response[0][i]['milestone_weightage'] + '</td><td>' +
                    response[0][i]['project_name'] +
                    '</td><td> <a href="milestones/' + response[0][i]["id"] +
                    '/edit" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Edit Milestone"> <i class = "fas fa-edit"> </i> </a> &nbsp; <a href="milestones/' +
                    response[0][i]["id"] +
                    '" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Milestone"> <i class = "fas fa-eye"> </i> </a> </td>  </tr>'
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