@php
$required = (Str::contains($field['rules'], 'required')) ? "required" : "";
$required_mark = ($required != "") ? '<span class="text-danger"> <strong>*</strong> </span>' : '';
@endphp

<div class="form-group mb-3 {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label class="form-label" for="{{ $field['name'] }}">
        <strong>{{ __($field['label']) }}</strong> ({{ $field['name'] }}) {!! $required_mark !!}
    </label>
    <div class="form-input">
        @foreach(Arr::get($field, 'options', []) as $val => $label)
            <input type="radio" @if( old($field['name'], setting($field['name'])) == $val ) checked @endif name="{{ $field['name'] }}" value="{{ $val }}"> {{ $label }}
        @endforeach
    </div>
    @if ($errors->has($field['name'])) <small class="invalid-feedback">{{ $errors->first($field['name']) }}</small> @endif
</div>