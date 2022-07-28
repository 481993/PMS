<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'department_id';
            $field_lable = __('Department');
            $field_relation = 'department';
            $field_placeholder = __('Select a department');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-department')->attributes(["$required"]) }}
        </div>
    </div>
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
            $field_name = 'employee_id';
            $field_lable = __('Employee');
            $field_relation = 'employee';
            $field_placeholder = __('Select an employee');
            $required = 'required';
            // $multiple = "multiple='multiple'";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name,isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder) ->class('form-control select2-employee')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group" style="display: none">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Project Assign Employee Name';
   
            ?>
            {{ html()->label($field_lable, $field_name) }} 
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control') }}
        </div>
    </div>
    <!-- <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            // $field_name = 'slug';
            // $field_lable = label_case($field_name);
            // $field_placeholder = $field_lable;
            // $required = "";
            ?>
            {{-- {{ html()->label($field_lable, $field_name) }}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control') }} --}}
        </div>
    </div> -->

</div>

<!-- Select2 Library -->
<x-library.select2 />

@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2-department').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a Department")',
                // minimumInputLength: 2,
                minimumResultsForSearch: Infinity,
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
                        $(".select2-project").empty();
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            var department_selected;
            $('.select2-selection').blur(function() {
                department_selected = $('.select2-department').val();
                console.log(department_selected);
            });

            $('.select2-project').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a Project")',
                // minimumInputLength: 2,
                minimumResultsForSearch: Infinity,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.projects.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim($('.select2-department').val())
                        };
                    },
                    processResults: function(data) {
                        $(".select2-project").empty();
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
                // minimumInputLength: 2,
                minimumResultsForSearch: Infinity,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.employees.index_list') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim($('.select2-project').val()),
                            module: 'projectassign'
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
                // minimumInputLength: 2,
                minimumResultsForSearch: Infinity,
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


            // $("submit").change(function() {

            //     $projectid = $('#project_id').val();
            //     $employeeid = $('#employee_id').val();

            //     if ($projectid == null && $employeeid == null) {
            //         alert('Hello');
            //         // $sql_que = "SELECT * FROM `projectassigns` LEFT JOIN projects ON projectassigns.project_id = projects.id LEFT JOIN employees ON projectassigns.employee_id = employees.id WHERE projectassigns.project_id != projects.id && projectassigns.employee_id != employees.id"
            //     } else {
            //         alert('Hy');
            //     }

            // });
        });

        var action = $('.form').attr('action');
        var lastslash = action.length - action.lastIndexOf('/');
        var proassign_id = action.substr(action.length - (lastslash - 1));
        if (proassign_id) {
            $.ajax({
                url: '{{ route("backend.$module_name.fetch_dropdown_value") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    proassign_id: proassign_id
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
                    /*if (response.taskname && response.task_id) {
                        var option_html = '<option value="'+response.task_id+'" selected="selected">'+response.taskname+'</option>';
                        $('#task_id').append(option_html);
                    } 
                    else {
                        console.log('task not loaded');
                    }*/
                    if (response.deptname && response.department_id) {
                        var option_html = '<option value="' + response.department_id +
                            '" selected="selected">' + response.deptname + '</option>';
                        $('#department_id').append(option_html);
                    } else {
                        console.log('milestones not loaded');
                    }
                },
                error: function(response) {
                    console.log('fetch_dropdown_value not loaded.');
                }
            });
        }


        
    </script>
@endpush
