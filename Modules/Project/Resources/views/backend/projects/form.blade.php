<div class="row">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Project Name';
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    {{-- <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            // $field_name = 'slug';
            // $field_lable = label_case($field_name);
            // $field_placeholder = $field_lable;
            // $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div> --}}
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'project_type';
            $field_lable = label_case($field_name);
            $field_relation = 'projecttype';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation) : '')->placeholder($field_placeholder)->class('form-control select2-projecttype')->attributes(["$required"]) }}      
        
            {{-- project_type <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>{{ $user->name }}</option> --}}
            {{-- <option value='{{$key}}' @if(!is_null(old($field_name)) && old($field_name) == $key) selected='selected' @endif>{{$value}}</option> --}}
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'start_date';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date start_date" id="{{ $field_name }}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target' => "#$field_name"])}}
                <div class="input-group-append" data-target="#{{ $field_name }}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'end_date';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date end_date" id="{{ $field_name }}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target' => "#$field_name"]) }}
                <div class="input-group-append" data-target="#{{ $field_name }}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'estimated_hours';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_lable = label_case($field_name);
            $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '1' => 'Published',
                '0' => 'Unpublished',
                '2' => 'Draft',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'priority';
            $field_lable = label_case($field_name);
            $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '1' => 'High',
                '2' => 'Medium',
                '3' => 'Low',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'departments_id';
            $field_lable = label_case('Department Name');
            $field_relation = 'departments';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-departments')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'project_manager';
            $field_lable = label_case('Project Manager');
            $field_relation = 'project_manager';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-employees')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'client';
            $field_lable = label_case('Client Name');
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>

</div>


<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-styles')
    <!-- File Manager -->
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            
            $('.select2-departments').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Department")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.departments.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('.select2-projecttype').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Project Type")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.projecttypes.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('.select2-employees').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Project Manager")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.employees.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim(params.term),
                            module: 'project'
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>



    <!-- Date Time Picker & Moment Js-->
    <script type="text/javascript">
     $(document).ready(function() {
        $(function() {
            /*$('.start_date').datetimepicker({
                format: 'YYYY-MM-DD',
                daysOfWeekDisabled: [0, 6],
                minDate: '<?= date('Y-m-d') ?>',
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar-alt',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'fas fa-times'
                }
            });
            $('.end_date').datetimepicker({
                format: 'YYYY-MM-DD',
                daysOfWeekDisabled: [0, 6],
                minDate: '<?= date('Y-m-d') ?>',
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar-alt',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'fas fa-times'
                }
            });*/
            var st_dt, en_dt;
            $(function() {
                function countSatSun(start, end) {
                   // if (end < start) return; //avoid infinite loop;
                    for (var count = {
                            satsun: 0
                        }; 
                        start < end; start.setDate(start.getDate() + 1)) {
                        if (start.getDay() == 0) count.satsun++;
                        else if (start.getDay() == 6) count.satsun++;
                    }
                    if (end<=start)
                    {
                        //alert('345');
                   // alert('Check end date. End date should be greater than that start date');
                    }
                    return count;
                }

                $('.start_date .datetimepicker-input').blur(function() {
                   

                    //$('.chk').click(function(){
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    // if(en_dt>st_dt)
                    // {
                       
                    //   $('#startdate').removeClass('error');
                    //   //$('.error').css('color','blue');
                        
                    // //    $('.error').css('color','red');\
                
                    //     // alert("correct");
                    //     //$('#startdate').removeClass('error');
                    // }
                    // else{
                    //     alert('fail');
                    //     $('#startdate').addClass('error');
                    //     $('.error').css('color','red');
                        
                    // }
                    // alert(st_dt);
                    // alert(en_dt);
                   // alert(st_dt);
                    //});
                    // $('.end_date').datetimepicker({
                    //     format: 'YYYY-MM-DD',
                    //     daysOfWeekDisabled: [0, 6],
                    //     minDate: st_dt,
                    //     icons: {
                    //         time: 'far fa-clock',
                    //         date: 'far fa-calendar-alt',
                    //         up: 'fas fa-arrow-up',
                    //         down: 'fas fa-arrow-down',
                    //         previous: 'fas fa-chevron-left',
                    //         next: 'fas fa-chevron-right',
                    //         today: 'far fa-calendar-check',
                    //         clear: 'far fa-trash-alt',
                    //         close: 'fas fa-times'
                    //     }
                    // });
                    countEsthrs();
                });

                function countEsthrs() {
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt),
                        diff = new Date(end_date - start_date),
                        days = diff / 1000 / 60 / 60 / 24;
                    days += 1;
                    var ctsatsun = countSatSun(start_date, end_date);
                    var totbusinessdays = days - ctsatsun.satsun;
                    var est_hrs = totbusinessdays * 8;
                    if(Math.sign(est_hrs) > 0){
                        $('#estimated_hours').val(est_hrs);
                    }
                    else{
                        $('#estimated_hours').val(0);
                    }
                }

                $('.end_date .datetimepicker-input').blur(function() {
                    en_dt = $('.end_date').data('date');
                    st_dt = $('.start_date').data('date');
                    // if(en_dt>st_dt)
                    // {
                    //     // alert("correct");
                    //     $('#startdate').removeClass("error");
                    // }
                    // else{
                    //    // alert('fail');
                    //    //$('.error').css('color','red');
                    //    $('startdate').addClass("error");
                    // }
                    
                    /*st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt),
                        diff = new Date(end_date - start_date),
                        days = diff / 1000 / 60 / 60 / 24;
                    days += 1;
                    var ctsatsun = countSatSun(start_date, end_date);
                    var totbusinessdays = days - ctsatsun.satsun;
                    var est_hrs = totbusinessdays * 8;
                    if(est_hrs){
                        $('#estimated_hours').val(est_hrs);
                    }
                    else{
                        $('#estimated_hours').val(0);
                    }*/
                    countEsthrs();
                });

                $('form').submit(function(){
                    countEsthrs();
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt);

                    // if(start_date > end_date){
                    //     alert('123');
                    //     alert('Please select end date is greater then start date.');
                    //     return false;
                    // }
                });
            });
        });

        var action = $('.form').attr ('action');
        var lastslash = action.length - action.lastIndexOf('/');
        var pro_id = action.substr(action.length-(lastslash-1));
        if(!isNaN(pro_id)){
            $.ajax({
                url: '{{ route("backend.$module_name.get_dept_pro_manager") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    project_id: pro_id
                },
                success: function (response) {
                    /*console.log(response);
                    console.log(response.name);
                    console.log(response.departments_id);*/
                    if (response.deptname && response.departments_id) {
                        var option_html = '<option value="'+response.departments_id+'" selected="selected">'+response.deptname+'</option>';
                        $('#departments_id').append(option_html);
                    } 
                    else {
                        console.log('departments not loaded');
                    }
                    if (response.empname && response.project_manager) {
                        var option_html = '<option value="'+response.project_manager+'" selected="selected">'+response.empname+'</option>';
                        $('#project_manager').append(option_html);
                    } 
                    else {
                        console.log('project_manager not loaded');
                    }
                    if (response.projecttypename && response.project_type) {
                        var option_html = '<option value="'+response.project_type+'" selected="selected">'+response.projecttypename+'</option>';
                        $('#project_type').append(option_html);
                    } 
                    else {
                        console.log('projecttype not loaded');
                    }
                },
                error: function (response) {
                    console.log('Dropdown values not loaded.'+response);
                }
            });

            $('.start_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('.end_date').datetimepicker({
                format: 'YYYY-MM-DD',
                // minDate: moment($('.start_date').data('date'))
            });
        }
        else{
            $('.start_date').datetimepicker({
            format: 'YYYY-MM-DD',
            daysOfWeekDisabled: [0,6],
            minDate: '<?= date('Y-m-d'); ?>',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar-alt',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'far fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'fas fa-times'
            }
        });

        /*$('.end_date').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment($('.start_date').data('date'))

        });*/ 
   

        } 
         $('.start_date.datetimepicker-input').blur(function(){

//$('.chk').click(function(){
    st_dt = $('.start_date').data('date');
    en_dt = $('.end_date').data('date');
    // alert(st_dt);
    // alert(en_dt);
    //alert(st_dt);
 
//});
});
$('#end_date').datetimepicker({
    format: 'YYYY-MM-DD',
    daysOfWeekDisabled: [0,6],
    minDate: $('.start_date').data('date'),
    
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar-alt',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'far fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'fas fa-times'
    }
   
});

     });
    </script>


@endpush
