<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'project_id';
            $field_lable = __("Project");
            $field_relation = "project";
            $field_placeholder = __("Select a project");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-project')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'milestone_id';
            $field_lable = __("Milestone");
            $field_relation = "milestone";
            $field_placeholder = __("Select a milestone");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-milestone')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'employee_id';
            $field_lable = __("Employee");
            $field_relation = "employee";
            $field_placeholder = __("Select an employee");
            $required = "required";
            $user = Auth::user();
            // echo '<pre>';
            // print_r($user);
            if(isset($user) && !empty($user)){
                $empvalue = 'value="'.$user->id.'"';
            }
            $readonly = 'readonly="true"';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <!-- {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-employee')->attributes(["$required"]) }} -->
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", "$empvalue", "$readonly"]) }}
        </div>
    </div>
</div>
<div class="row">
<div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'task_id';
            $field_lable = __("Task");
            $field_relation = "task";
            $field_placeholder = __("Select an task");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-task')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Timelog Name';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <!-- <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            // $field_name = 'slug';
            // $field_lable = label_case($field_name);
            // $field_placeholder = $field_lable;
            // $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div> -->
</div>
<hr>

<div class="row">
    <div class="col-4 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'log_date';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date log_date" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'start_time';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date start_time" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append chk" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'end_time';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date start_time" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append chk" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'spend_hours';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push ('after-scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.select2-project').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select a project")',
        minimumResultsForSearch: Infinity,
        // minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{route("backend.projects.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                $(".select2-milestone").empty();
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    // var project_selected;
    // $('.select2-selection').blur(function(){
    //     project_selected = $('.select2-project').val();
    //     console.log(project_selected);
    // });

    $('.select2-milestone').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select a Milestone")',
        // minimumInputLength: 2,
        minimumResultsForSearch: Infinity,
        allowClear: true,
        ajax: {
            url: '{{route("backend.milestones.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $('.select2-project').val()
                };
            },
            processResults: function (data) {
                $(".select2-task").empty();
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.select2-employee').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select a employee")',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{route("backend.employees.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.select2-task').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select a task")',
        // minimumInputLength: 2,
        minimumResultsForSearch: Infinity,
        allowClear: true,
        ajax: {
            url: '{{route("backend.tasks.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim($('.select2-milestone').val())
                };
            },
            processResults: function (data) {
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
    $('.log_date').datetimepicker({
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

    $('.start_time').datetimepicker({
        format: 'HH:mm:ss',
    });
    $('.end_time').datetimepicker({
        format: 'hh:mm:ss',
    });
});

    var action = $('.form').attr ('action');
    var lastslash = action.length - action.lastIndexOf('/');
    var timelog_id = action.substr(action.length-(lastslash-1));
    if(timelog_id){
        $.ajax({
            url: '{{ route("backend.$module_name.fetch_dropdown_value") }}',
            //context: document.body,
            dataType: 'json',
            data: {
                timelog_id: timelog_id
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
                /*if (response.empname && response.employee_id) {
                    var option_html = '<option value="'+response.employee_id+'" selected="selected">'+response.empname+'</option>';
                    $('#employee_id').append(option_html);
                } 
                else {
                    console.log('employee not loaded');
                }*/
                if (response.taskname && response.task_id) {
                    var option_html = '<option value="'+response.task_id+'" selected="selected">'+response.taskname+'</option>';
                    $('#task_id').append(option_html);
                } 
                else {
                    console.log('task not loaded');
                }
                if (response.milename && response.milestone_id) {
                    var option_html = '<option value="'+response.milestone_id+'" selected="selected">'+response.milename+'</option>';
                    $('#milestone_id').append(option_html);
                } 
                else {
                    console.log('milestones not loaded');
                }
            },
            error: function (response) {
                console.log('fetch_dropdown_value not loaded.');
            }
        });
    }
</script>
@endpush