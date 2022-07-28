<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Department Name';
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    {{-- <div class="col-12 col-sm-6">
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

@push('after-styles')
    <!-- File Manager -->
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

@endpush

@push('after-scripts')
    <script type="text/javascript">
        // $(document).ready(function() {

            // $('[type=submit]').click(function() {

            //     var s = $('#status').val();
            //     if (s == '') {
            //         $('.form-control .select2 .error').find('.error').attr('id', 'validation_error');
            //     } 
            // });

            // $('#form').validate({ // initialize the plugin
            //     rules: {
            //         name: {
            //             required: true,
            //             maxlength: 15
            //         },
            //         // slug: {
            //         //     required: false,
            //         //     maxlength: 15
            //         // }
            //         status: {
            //             required: true
            //         }
            //     },
            //     messages: {
            //         name: {
            //             required: 'Please enter department name.',
            //             maxlength: 'Max 15 char is valid.'
            //         },
            //         // slug: {
            //         //     required : 'Please Enter Slug Name.'
            //         // },
            //         status: {
            //             required: 'Please select valid status.'
            //         }
            //     }
            // });

        // });
    </script>

@endpush

