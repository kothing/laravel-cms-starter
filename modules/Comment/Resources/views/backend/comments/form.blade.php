<?php
$user_id_value = '';
$published_at_value = '';
$moderated_at_value = '';
$parent_name = '';

if (isset($$module_name_singular)) {
    $user_id_value = ($$module_name_singular->user_name != '') ? $$module_name_singular->user_name : '';
    $parent_name = ($$module_name_singular->parent_id != '') ? $$module_name_singular->parent->name : '';
    $published_at_value = ($$module_name_singular->moderated_at != '') ? $$module_name_singular->moderated_at->isoFormat('llll') : '';
    $moderated_at_value = ($$module_name_singular->moderated_at != '') ? $$module_name_singular->moderated_at->isoFormat('llll') : '';
}
?>
<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = "required";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_label = label_case($field_name);
            $field_placeholder = __("Select an option");
            $required = "required";
            $select_options = [
                '0'=>'Pending',
                '1'=>'Published',
                '2'=>'Rejected',
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2-status')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'comment';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'user_id';
            $field_label = "User";
            $field_relation = "user";
            $field_placeholder = __("Select an option");
            $required = "required";
            $value = $user_id_value;
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control select2-users')->attributes(["$required"])->value($value)->disabled() }}
            {{ html()->hidden($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            
            <!--{{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->user_name) : '')->placeholder($field_placeholder)->class('form-control select2-users')->attributes(["$required"])->value($value) }}-->
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'parent_id';
            $field_label = "Parent Comment";
            $field_relation = "parent";
            $field_placeholder = __("Select an option");
            $required = "required";
            $value = $parent_name;
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"])->value($value)->disabled() }}
            {{ html()->hidden($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <!--{{ html()->select($field_name, isset($$module_name_singular) ? optional($$module_name_singular->parent_id) : '')->placeholder($field_placeholder)->class('form-control select2-posts')->attributes(["$required"])->value($value) }}-->
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'moderated_at';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = "";
            $value = $moderated_at_value;
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"])->value($value)->disabled() }}
            {{ html()->hidden($field_name)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'published_at';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = "";
            $value = $published_at_value;
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"])->value($value)->disabled() }}
            {{ html()->hidden($field_name)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

@push('after-styles')

<!-- Date Time Picker -->
<link href="{{ asset('vendor/datetime-picker/datetime-picker.css') }}" rel="stylesheet">

@endpush

<!-- Select2 Library -->
<x-library.select2 />

@push ('after-scripts')

<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script type="module">
    $(document).ready(function() {
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
            document.querySelector('.select2-container--open .select2-search__field').focus();
        });

        if($('.select2-users').length > 0) {
            $('.select2-users').select2({
                theme: "bootstrap4",
                placeholder: "-- Select an option --",
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    url: '{{route("backend.users.index_list")}}',
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
        }
        
        if($('.select2-posts').length > 0) {
            $('.select2-posts').select2({
                theme: "bootstrap4",
                placeholder: "-- Select an option --",
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    url: '{{route("backend.posts.index_list")}}',
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
        }
    });
</script>

<!-- Datetime-picker & Moment Js-->
<script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/datetime-picker/datetime-picker.js') }}"></script>
<script type="module">
    new DateTimePicker("published_at", {
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            format: "YYYY-MM-DD HH:mm:ss",
        },
    });
</script>

@endpush
