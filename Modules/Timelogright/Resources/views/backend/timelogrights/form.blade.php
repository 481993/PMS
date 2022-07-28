<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'project_id';
            $field_lable = label_case('Project Name');
            $field_relation = 'projects';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-projects')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'task_id';
            $field_lable = __('Task');
            $field_relation = 'task';
            $field_placeholder = __('Select an task');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-task')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'employee_id';
            $field_lable = __('Employee');
            $field_relation = 'employee';
            $field_placeholder = __('Select an employee');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-employee')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Timelog Rights Name';
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <!-- <div class="col-12 col-sm-6">
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
    </div> -->
</div>
<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'add_rights';
            $field_lable = label_case($field_name);
            $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '0' => 'No',
                '1' => 'Yes',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'edit_rights';
            $field_lable = label_case($field_name);
            $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '0' => 'No',
                '1' => 'Yes',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'delete_rights';
            $field_lable = label_case($field_name);
            $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '0' => 'No',
                '1' => 'Yes',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<hr>

<div class="row">
    
    <div class="col-4 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'start_date';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date start_date" id="{{ $field_name }}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target' => "#$field_name"]) }}
                <div class="input-group-append" data-target="#{{ $field_name }}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4 col-sm-6">
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
                <div class="input-group-append chk" data-target="#{{ $field_name }}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12">
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

</div>

<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2-projects').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Project")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.projects.index_list') }}',
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

            $('.select2-task').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Task")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.tasks.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            p_id: $.trim($('.select2-projects').val())
                        };
                    },
                    processResults: function(data) {
                        $('.select2-task').empty()
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('.select2-employee').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Employee")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.employees.index_list') }}',
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
        });
    </script>

    <!-- Date Time Picker & Moment Js-->
    <script type="text/javascript">
        $(function() {
            $('.start_date').datetimepicker({
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
            var st_dt, en_dt;
            $(function() {
                function countSatSun(start, end) {
                    if (end < start) return; //avoid infinite loop;
                    for (var count = {
                            satsun: 0
                        }; start < end; start.setDate(start.getDate() + 1)) {
                        if (start.getDay() == 0) count.satsun++;
                        else if (start.getDay() == 6) count.satsun++;
                    }
                    return count;
                }

                $('.start_date .datetimepicker-input').blur(function() {

                    //$('.chk').click(function(){
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    // alert(st_dt);
                    // alert(en_dt);
                    console.log(st_dt);
                    //});
                    $('.end_date').datetimepicker({
                        format: 'YYYY-MM-DD',
                        daysOfWeekDisabled: [0, 6],
                        minDate: st_dt,
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

                // $('.end_date .datetimepicker-input').blur(function() {
                //     st_dt = $('.start_date').data('date');
                //     en_dt = $('.end_date').data('date');
                //     var end_date = new Date(en_dt),
                //         start_date = new Date(st_dt),
                //         diff = new Date(end_date - start_date),
                //         days = diff / 1000 / 60 / 60 / 24;
                //     days += 1;
                //     var ctsatsun = countSatSun(start_date, end_date);
                //     var totbusinessdays = days - ctsatsun.satsun;
                //     var est_hrs = totbusinessdays * 8;
                //     $('#estimated_hours').val(est_hrs);
                // });
            });
        });
        var action = $('.form').attr ('action');
        var lastslash = action.length - action.lastIndexOf('/');
        var timelogright_id = action.substr(action.length-(lastslash-1));
        if(timelogright_id){
            $.ajax({
                url: '{{ route("backend.$module_name.fetch_dropdown_value") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    timelogright_id: timelogright_id
                },
                success: function (response) {
                    console.log(response);
                    if (response.proname && response.project_id) {
                        var option_html = '<option value="'+response.project_id+'" selected="selected">'+response.proname+'</option>';
                        $('#project_id').append(option_html);
                    } 
                    else {
                        console.log('projects not loaded');
                    }
                    if (response.empname && response.employee_id) {
                        var option_html = '<option value="'+response.employee_id+'" selected="selected">'+response.empname+'</option>';
                        $('#employee_id').append(option_html);
                    } 
                    else {
                        console.log('employee not loaded');
                    }
                    if (response.taskname && response.task_id) {
                        var option_html = '<option value="'+response.task_id+'" selected="selected">'+response.taskname+'</option>';
                        $('#task_id').append(option_html);
                    } 
                    else {
                        console.log('task not loaded');
                    }
                    /*if (response.milename && response.milestone_id) {
                        var option_html = '<option value="'+response.milestone_id+'" selected="selected">'+response.milename+'</option>';
                        $('#milestone_id').append(option_html);
                    } 
                    else {
                        console.log('milestones not loaded');
                    }*/
                },
                error: function (response) {
                    console.log('fetch_dropdown_value not loaded.');
                }
            });
        }
    </script>
@endpush
