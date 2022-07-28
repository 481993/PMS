<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Employee Name';
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
    
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'employee_department';
            $field_lable = label_case('Employee Department');
            $field_relation = 'employeerole';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-employee_department')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'employeerole';
            $field_lable = label_case('Employee Role');
            $field_relation = 'employeerole';
            $field_placeholder = __('Select an option');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-employeerole')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'user_id';
            $field_lable = label_case('User');
            $field_relation = 'user';
            $field_placeholder = __('Select an User');
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->$field_relation)->pluck('name', 'id') : '')->placeholder($field_placeholder)->class('form-control select2-user')->attributes(["$required"]) }}
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
            $('.select2-employeerole').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select Employee Role")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.employeeroles.index_list') }}',
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
        
            $('.select2-employee_department').select2({
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

            $('.select2-user').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select User")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.users.index_list') }}',
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
        var action = $('.form').attr ('action');
        var lastslash = action.length - action.lastIndexOf('/');
        var emp_id = action.substr(action.length-(lastslash-1));
        if(emp_id){
            $.ajax({
                url: '{{ route("backend.$module_name.fetch_dropdown_value") }}',
                //context: document.body,
                dataType: 'json',
                data: {
                    emp_id: emp_id
                },
                success: function (response) {
                    if (response.empdeptname && response.employee_department) {
                        var option_html = '<option value="'+response.employee_department+'" selected="selected">'+response.empdeptname+'</option>';
                        $('#employee_department').append(option_html);
                    } 
                    else {
                        console.log('departments not loaded');
                    }
                    if (response.emprolename && response.employeerole) {
                        var option_html = '<option value="'+response.employeerole+'" selected="selected">'+response.emprolename+'</option>';
                        $('#employeerole').append(option_html);
                    } 
                    else {
                        console.log('employee role not loaded');
                    }
                    if (response.username && response.user_id) {
                        var option_html = '<option value="'+response.user_id+'" selected="selected">'+response.username+'</option>';
                        $('#user_id').append(option_html);
                    } 
                    else {
                        console.log('employee user not loaded');
                    }
                },
                error: function (response) {
                    console.log('fetch_dropdown_value not loaded.');
                }
            });
        }

    </script>

@endpush
