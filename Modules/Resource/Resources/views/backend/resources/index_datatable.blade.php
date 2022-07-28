@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>Resources Availability</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body tf_card_body">
        <div class="info_color">
            <h3>
                <span class="cl_gr">&nbsp;</span>
                <span class="cl_text">Available</span>
            </h3>
            <h3>
                <span class="cl_rd">&nbsp;</span>
                <span class="cl_text">Book</span>
            </h3>
            <h3>
                <span class="cl_bl">&nbsp;</span>
                <span class="cl_text">Overload</span>
            </h3>
            <h3>
                <span class="cl_gy">&nbsp;</span>
                <span class="cl_text">Vacation</span>
            </h3>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> Resources Availability  
                    <!-- <small class="text-muted">Data Table {{ $module_action }}</small> -->
                </h4>
                <!-- <div class="small text-muted">
                    {{ Str::title($module_name) }} Management Dashboard
                </div> -->
            </div>
        </div>
        <!--/.row-->
        <div class="rescalendar" id="my_calendar_en"></div>
    </div>
</div>

@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('vendor/rescalendar/css/rescalendar.css') }}">
<style>

    body{
        text-align: center;
       
        background-color: #fafafa;
    }

    h1{
        margin: 150px 0 100px 30px;
    }

    h4{
        margin: 60px 0 10px 60px;
    }

    .wrapper{
        width: 100%;
        text-align: center;
    }

    .greenClass{
        background: green;
    }

    .blueClass{
        background: blue;
    }

    .grayClass{
        background: gray;
    }

    .redClass{
        background: red;
    }

</style>
@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
{{-- <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script src="{{ asset('vendor/rescalendar/js/rescalendar.js') }}"></script>
{{-- <script type="text/javascript">

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.index_data") }}',
        columns: [
            // {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

</script> --}}
<script>
    var rec_data;
    var emp_list;
    $(document).ready(function(){
        $.ajax({ url: '{{ route("backend.$module_name.get_emp_detail") }}',
            context: document.body,
            success: function(data){
                emp_list = JSON.parse(data);
                // console.log(emp_list);
                // alert(emp_list);
                $.ajax({ url: '{{ route("backend.$module_name.get_task_detail") }}',
                    context: document.body,
                    success: function(data){
                    // alert(data);
                    // console.log(data);
                        rec_data = JSON.parse(data);
                        // console.log(rec_data);
                        // alert(rec_data);
                        $('#my_calendar_en').rescalendar({
                            id: 'my_calendar_en',
                            format: 'DD-MM-YYYY',
                            refDate: '<?php echo date("d-m-Y"); ?>',
                            jumpSize: 15,
                            // disabledDays: ['2019-01-01', '2019-01-07', '2019-04-18', '2019-04-19', '2019-05-01', '2019-05-02', '2019-05-13', '2019-08-15', '2019-10-12', '2019-11-01', '2019-12-06', '2019-12-09', '2019-12-20', '2019-12-24', '2019-12-25', '2019-12-31'],
                            disabledWeekDays: [0,6],
                            data: rec_data,

                            dataKeyField: 'name',
                            dataKeyValues: emp_list

                        });
                        // $(".firstColumn").each(function(e) {
                        //     // alert($(this).html());
                        //     var text = $(this).html();
                        //     text = text.replace("_", " ");
                            
                        //     text = text.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        //         return letter.toUpperCase();
                        //     });
                        //     $(this).text(text);
                        // });
                    }
                });
            }
        });
    });
</script>
@endpush
