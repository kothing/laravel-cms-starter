<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_label = __("article::$module_name.$field_name");
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
            $field_name = 'slug';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'created_by_alias';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = "Hide Author User's Name and use Alias";
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'order';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'category_id';
            $field_label = __("article::$module_name.$field_name");
            $field_relation = "category";
            $field_placeholder = __("Select an option");
            $required = "required";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-category')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $select_options = [
                '1' => __('Published'),
                '0' => __('Unpublished'),
                '2' => __('Draft')
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'tags_list[]';
            $field_label = __("article::$module_name.tags");
            $field_relation = "tags";
            $field_placeholder = __("Select an option");
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->multiselect($field_name,
                isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'',
                isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('id')->toArray():''
                )->class('form-control select2-tags')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'intro';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'content';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "required";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'type';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "";
            $select_options = [
                'Article' => 'Article',
                // 'Feature' => 'Feature',
                // 'News' => 'News',
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'published_at';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            <!--{{ html()->datetime($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker')->attributes(["$required"]) }}-->
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'featured_image';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            <div class="input-group">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image', 'aria-describedby'=>'button-image']) }}
                <div class="input-group-append">
                    <button class="btn btn-info border-radius-l-0" type="button" id="button-image" data-input="{{$field_name}}"><i class="fas fa-folder-open"></i> @lang('Browse')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'is_featured';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "";
            $select_options = [
                '1' => __('Yes'),
                '0' => __('No'),
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'meta_title';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'meta_keywords';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'meta_description';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'meta_og_image';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'meta_og_url';
            $field_label = __("article::$module_name.$field_name");
            $field_placeholder = $field_label;
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<!-- Select2 Library -->
<x-library.select2 />
@push ('after-scripts')
<script type="module">
    $(document).ready(function() {
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
            document.querySelector('.select2-container--open .select2-search__field').focus();
        });

        $('.select2-category').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: '{{route("backend.categories.index_list")}}',
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

        $('.select2-tags').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: '{{route("backend.tags.index_list")}}',
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
@endpush

<!-- Datetime-picker CSS -->
@push('after-styles')
<link href="{{ asset('vendor/datetime-picker/datetime-picker.css') }}" rel="stylesheet">
@endpush

<!-- Datetime-picker JS -->
@push('after-scripts')
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

<!-- Summernote editor -->
<x-library.summernote />