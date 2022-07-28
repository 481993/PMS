<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'project_id';
            $field_lable = __('Project');
            $field_relation = 'project';
            $field_placeholder = __('Select a project');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-project')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'milestone_id';
            $field_lable = __('Milestone');
            $field_relation = 'milestone';
            $field_placeholder = __('Select a milestone');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-milestone')->attributes(["$required"]) }}
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
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-employee')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Task Name';
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
            // $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
</div>
</div> --}}
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'task_type';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            <!-- {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }} -->

            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-tasktype')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'task_description';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-4 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'task_priority';
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
    <div class="col-4 col-sm-4">
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

    <div class="col-4 col-sm-4">
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
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'estimated_hours';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'task_status';
            $field_lable = label_case($field_name);
            // $field_placeholder = '-- Select an option --';
            $required = 'required';
            $select_options = [
                '0' => 'New',
                '1' => 'Inprogress',
                '2' => 'Closed',
                '3' => 'Reopen',
            ];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->value($select_options[0])->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
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
</div>
<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'assign_by';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            $disabled = "readonly='true'";
            $user = Auth::user();
            //var_dump($user);
            $assign_by_id = $user->id;
            //var_dump($assign_by_id);
            $assign_by_value = 'value="' . $user->id . '"';
            ?>
            <!-- {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} -->
            {{ html()->hidden($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", "$assign_by_value", "$disabled"]) }}
        </div>
    </div>
</div>
<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2-project').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a project")',
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
                        $(".select2-project").empty();
                        $(".select2-milestone").empty();
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            var project_selected;
            $('.select2-selection').blur(function() {
                project_selected = $('.select2-project').val();
                console.log(project_selected);
            });
            // $('.select2-project').on("select2:select", function (e) {
            // project_selected = $('.select2-project').select2().val();
            // });
            $('.select2-milestone').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a milestone")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.milestones.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        // alert(params);
                        // console.log(params);
                        return {
                            q: $('.select2-project').val()
                        };
                    },
                    processResults: function(data) {
                        $(".select2-milestone").empty();
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
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.employees.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim($('.select2-project').val()),
                            module: 'task'
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

            $('.select2-tasktype').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a task type")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.tasktypes.index_list') }}',
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
        CKEDITOR.replace( 'task_description' );
        
    </script>

    <!-- Date Time Picker & Moment Js-->
    <script type="text/javascript">
        $(function() {

            st_dt = $('.start_date').data('date');
            en_dt = $('.end_date').data('date');

            

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
                    });*/
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
                    /*if(end< start)
                    {
                        alert('Check end date. End date should be greater than that start date');
                    }*/
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
                });

                $('.end_date .datetimepicker-input').blur(function() {
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt),
                        diff = new Date(end_date - start_date),
                        days = diff / 1000 / 60 / 60 / 24;
                    days += 1;
                    var ctsatsun = countSatSun(start_date, end_date);
                    if (ctsatsun) {
                        var totbusinessdays = days - ctsatsun.satsun;
                    }
                    if (totbusinessdays) {
                        var est_hrs = totbusinessdays * 8;
                    }
                    if (est_hrs) {
                        $('#estimated_hours').val(est_hrs);
                    } else {
                        $('#estimated_hours').val(0);
                    }
                });

                $('form').on('submit', function(e) {
                    //alert();
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt);
                    if (end_date < start_date) {
                        alert('Check end date. End date should be greater than that start date');
                        //e.preventDefault();
                        return false;
                    }
                });
            });
        });

        var action = $('.form').attr('action');
        var lastslash = action.length - action.lastIndexOf('/');
        var task_id = action.substr(action.length - (lastslash - 1));
        if (!isNaN(task_id)) {
            $.ajax({
                url: '{{ route("backend.$module_name.fetch_dropdown_value") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    task_id: task_id
                },
                success: function(response) {
                    console.log(response);
                    if (response.proname && response.project_id) {
                        var option_html = '<option value="' + response.project_id + '" selected="selected">' +
                            response.proname + '</option>';
                        $('#project_id').append(option_html);
                    } else {
                        console.log('projects not loaded');
                    }
                    if (response.empname && response.employee_id) {
                        var option_html = '<option value="' + response.employee_id + '" selected="selected">' +
                            response.empname + '</option>';
                        $('#employee_id').append(option_html);
                    } else {
                        console.log('employee not loaded');
                    }
                    if (response.tasktypename && response.task_type) {
                        var option_html = '<option value="' + response.task_type + '" selected="selected">' +
                            response.tasktypename + '</option>';
                        $('#task_type').append(option_html);
                    } else {
                        console.log('task_type not loaded');
                    }
                    if (response.milename && response.milestone_id) {
                        var option_html = '<option value="' + response.milestone_id + '" selected="selected">' +
                            response.milename + '</option>';
                        $('#milestone_id').append(option_html);
                    } else {
                        console.log('milestones not loaded');
                    }
                },
                error: function(response) {
                    console.log('fetch_dropdown_value not loaded.');
                }
            });

            
            $('.start_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('.end_date').datetimepicker({
                format: 'YYYY-MM-DD'
                // minDate: moment($('.start_date').data('date'))
            });

            
            
        } else {
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

            /*$('.end_date').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment($('.start_date').data('date'))

            });*/
            $('.end_date').datetimepicker({
                format: 'YYYY-MM-DD',
                daysOfWeekDisabled: [0, 6],
                minDate: moment($('.start_date').data('date')),
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
        }
    </script>
@endpush
