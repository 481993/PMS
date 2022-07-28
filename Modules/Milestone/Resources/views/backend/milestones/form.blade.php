<div class="row">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Milestone Name';
            $required = 'required';
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
            // $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div> -->
    <div class="col-12 col-sm-6">
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

    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'hours';
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
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'milestone_weightage';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = '';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <!-- {{ html()->range($field_name)->placeholder($field_placeholder)->class('form-control')->id('myRange')->value('50')->attributes(["$required"]) }} -->
            <input class="form-control" type="range" name="milestone_weightage" id="myRange" value="{{ html()->value('milestone_weightage') }}" placeholder="Milestone Weightage">
            <p>Value: <span id="demo"> {{ html()->value('milestone_weightage') }} </span></p>
            
        </div>
    </div>
    <div class="col-12 col-sm-6">
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
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'milestone_short_description';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = 'required';
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
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
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
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

            $('.select2-tasks').select2({
                theme: "bootstrap",
                placeholder: '@lang("Select a project")',
                minimumResultsForSearch: Infinity,
                // minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url: '{{ route('backend.tasks.index_list') }}',
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
            CKEDITOR.replace( 'milestone_short_description' );
            // $('.select2-projects').select2({
            //     theme: "bootstrap",
            //     placeholder: '@lang("Select an option")',
            //     minimumInputLength: 2,
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
        });
    </script>

<script>
var slider = document.getElementById("myRange");
var out = document.getElementById("demo");
out.innerHTML = slider.value;

slider.oninput = function() 
{
    out.innerHTML = this.value;
}

// alert(slider);
// alert(out);

</script>

    <!-- Date Time Picker & Moment Js-->
    <script type="text/javascript">
        $(function() {
            var st_dt, en_dt;
            $(function() {
                function countSatSun(start, end) {
                    // if (end < start) return; //avoid infinite loop;
                    for (var count = {
                            satsun: 0
                        }; start < end; start.setDate(start.getDate() + 1)) {
                        if (start.getDay() == 0) count.satsun++;
                        else if (start.getDay() == 6) count.satsun++;
                    }
                    if (end<start)
                    {
                    alert('Check end date. End date should be greater than that start date');
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
                    console.log(est_hrs);
                    if(Math.sign(est_hrs) > 0) {
                        $('#hours').val(est_hrs);
                    }
                    else{
                        $('#hours').val(0);
                    }
                }

                $('.end_date .datetimepicker-input').blur(function() {
                    countEsthrs();
                });

                $('form').submit(function(){
                    countEsthrs();
                    st_dt = $('.start_date').data('date');
                    en_dt = $('.end_date').data('date');
                    var end_date = new Date(en_dt),
                        start_date = new Date(st_dt);

                    if(start_date > end_date){
                        alert('Please select end date is greater then start date.');
                        return false;
                    }
                });
            });
        });

    var action = $('.form').attr ('action');
    var lastslash = action.length - action.lastIndexOf('/');
    var mile_id = action.substr(action.length-(lastslash-1));
    if(!isNaN(mile_id)){
        //alert();
        $.ajax({
            url: '{{ route("backend.$module_name.get_project") }}',
            //context: document.body,
            dataType: 'json',
            data: {
                milestone_id: mile_id
            },
            success: function (response) {
                console.log(response);
                // console.log(response.deptname);
                // console.log(response.departments_id);
                if (response.proname && response.project_id) {
                    var option_html = '<option value="'+response.project_id+'" selected="selected">'+response.proname+'</option>';
                    $('#project_id').append(option_html);
                } 
                else {
                    console.log('project not loaded');
                }
            },
            error: function (response) {
                alert('project not loaded.');
            }
        });

        $('.start_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        
        // $('.start_date .datetimepicker-input').blur(function() {
            // $('.end_date').datetimepicker({
            //     format: 'YYYY-MM-DD',
            //     minDate: moment($('.start_date').data('date'))
            // });
        //     alert($('.start_date').data('date'));
        //     $( ".end_date" ).datepicker( "option", "minDate", new Date(2007, 1 - 1, 1) );
        // });

        $('.end_date').datetimepicker({
            format: 'YYYY-MM-DD',
            // minDate: moment($('.start_date').data('date'))
        });
    }
    else{
        // alert('else');
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
        $('.end_date').datetimepicker({
            format: 'YYYY-MM-DD',
            daysOfWeekDisabled: [0,6],
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
