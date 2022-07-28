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
                        <i class="{{ $module_icon }}"></i><i class="fas fa-business-time c-sidebar-nav-icon"></i> {{ $module_title }}
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
            </div>
            <!--/.row-->

            <div class="row mt-4">
                <div class="col">
                    <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>
                                    Project Name
                                </th> 
                                <th>
                                    Log Date
                                </th>              
                                <th>
                                    Start Time
                                </th>
                                <th>
                                    End Time
                                </th>
                                <th>
                                    Spend Hours
                                </th>
                                <th>
                                    Employee Name
                                </th>
                                <th class="text-left">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id='bidders'>

                        </tbody>
                    </table>
                    <b> Total Spend Hours: <span class="spnTotSpendhrs"></span></b>
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
        //         {data: 'spend_hours', name: 'spend_hours'},
        //         {data: 'log_date', name: 'log_date'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        $.ajax({
            url: '{{ route("backend.$module_name.index_data") }}',
            //context: document.body,
            dataType: 'json',
            success: function(response) {
                //alert(response);
                var spend_hours = [];
                // var hour='';
                // var minute='';
                // var second='';
                for (var i = 0; i < response[0].length; i++) {
                    // var time1= response[0][i]['spend_hours'];
                    // var splitTime1= time1.split(':');
                    // hour[] = parseInt(splitTime1[0]));
                    // minute[] = parseInt(splitTime1[1]));
                    // second[] = parseInt(splitTime1[2]));
                     var hours =response[0][i]['spend_hours'];
                     var spendhours  = hours.split(":");
                     if(spendhours[1] > 0) {
                  var hours= spendhours[1]+ ' Min';
                } 
                else if (spendhours[0] > 0) {
                    var hours = spendhours[0]+ 'Hrs ' +spendhours[1]+ 'Min';
                }
                 else {
                   // var hourss = '' spendhours[0]+ 'Hrs ' +spendhours[1]+ 'Mins' +spendhours[2]+'Sec'
                   var hours = '0 Hrs';
                }
                    spend_hours[i] = response[0][i]['spend_hours'];
                    //alert(response[0][i]['spend_hours']);
                    var pro_end_dt = moment(response[0][i]['log_date']).format('D-MMM-YYYY');
                    $('#bidders').append('<tr><td>' + response[0][i][
                            'project_name'
                        ] + "</td><td>" +  pro_end_dt +  "</td><td>" + response[0][i][

                            'start_time'

                        ] + "</td><td>" + response[0][i][

                            'end_time'

                        ] + "</td><td>" +hours + '</td><td>' + response[0][i][

                            'employee_name'

                        ] + "</td>" +
                        '<td> <a href="timelogs/' + response[0][i]["id"] +
                        '/edit" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Edit Timelogs"> <i class = "fas fa-edit"> </i> </a> &nbsp; <a href="timelogs/' +
                        response[0][i]["id"] +
                        '" class="btn btn-success btn-sm " data-toggle="tooltip" title="Show Timelogs"> <i class = "fas fa-eye"> </i> </a> </td>  </tr>'
                    );
                }
                toSeconds = (str) => {
                    str = str.split(':');
                    // console.log(str);
                    return (+str[0]) * 3600 + (+str[1]) * 60 + (+str[2]);
                }

                toHHss = (seconds) => {
                    let hours = parseInt(seconds / 3600);
                    seconds = parseInt(seconds - (hours * 3600));
                    let minutes = parseInt(seconds / 60);
                    seconds = seconds - minutes * 60;
                    var hDisplay = (hours < 0 ? "00" : ("0"+hours).slice(-2)) + ":";
                    var mDisplay = (minutes < 0 ? "00" : ("0"+minutes).slice(-2)) + ":";
                    var sDisplay = (seconds < 0 ? "00" : ("0"+seconds).slice(-2));
                    return  hDisplay + mDisplay + sDisplay;
                }
                let result = spend_hours.reduce((r, elem) => r + toSeconds(elem), 0);
                var total_spend_hours = toHHss(result);
                //alert(total_spend_hours);
                $('#datatable').DataTable({
                    autoWidth: true,
                    responsive: true,
                });
                $('.spnTotSpendhrs').html(total_spend_hours);
            }
        });
    </script>
@endpush
