<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Project Type Name';
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

@push('after-styles')
    <!-- File Manager -->
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            // $('.select2-projects').select2({
            //     theme: "bootstrap",
            //     placeholder: '@lang("Select a project")',
            //     minimumResultsForSearch: Infinity,
            //     // minimumInputLength: 2,
            //     allowClear: true,
            //     ajax: {
            //         url: '{{ route('backend.projects.index_list') }}',
            //         dataType: 'json',
            //         data: function(params) {
            //             return {
            //                 q: $.trim(params.term)
            //             };
            //         },
            //         processResults: function(data) {
            //             return {
            //                 results: data
            //             };
            //         },
            //         cache: true
            //     }
            // });

            // $('.select2-tasks').select2({
            //     theme: "bootstrap",
            //     placeholder: '@lang("Select a project")',
            //     minimumResultsForSearch: Infinity,
            //     // minimumInputLength: 2,
            //     allowClear: true,
            //     ajax: {
            //         url: '{{ route('backend.tasks.index_list') }}',
            //         dataType: 'json',
            //         data: function(params) {
            //             return {
            //                 q: $.trim(params.term)
            //             };
            //         },
            //         processResults: function(data) {
            //             return {
            //                 results: data
            //             };
            //         },
            //         cache: true
            //     }
            // });

        });
    </script>

@endpush


