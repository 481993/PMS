@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>
        <!-- {{ $module_title }} -->
        
        <?php
                    if ($module_title   == 'Employeeroles') { ?>
                       Employee Roles
                    <?php
                    } else { ?>
                       {{ $module_title }}
                    <?php
                    }
                    ?>
    </x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    
                <?php
                    if ($module_title   == 'Employeeroles') { ?>
                        <i class="{{ $module_icon }}"></i><i class="fas fa-user-alt c-sidebar-nav-icon"></i>  Employee Roles
                    <?php
                    } else { ?>
                       <i class="{{ $module_icon }}"></i>  {{ $module_title }}
                    <?php
                    }
                    ?>
                    <!-- <small class="text-muted">Data Table {{ $module_action }}</small> -->
                </h4>
                <!-- <div class="small text-muted">
                    {{ Str::title($module_name) }} Management Dashboard
                </div> -->
            </div>
            <div class="col-4">
                <div class="float-right">
                    <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}"/>

                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <div class="btn-group" role="group">                            <!--<div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                                <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                    <i class="fas fa-eye-slash"></i> View trash
                                </a>
                            </div>--->
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
                            <!-- <th>
                                #
                            </th> -->
                            <th>
                                Name
                            </th>
                            <!-- <th>
                                Slug
                            </th> -->
                            <th>
                                Created By
                            </th>
                            <!-- <th>
                                Updated At
                            </th> -->
                            <th class="text-right">
                                Action
                            </th>
                        </tr>
                    </thead>
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

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript">

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.index_data") }}',
        columns: [
            // {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            // {data: 'slug', name: 'slug'},
            {data: 'created_by', name: 'created_by'},
            // {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

</script>
@endpush