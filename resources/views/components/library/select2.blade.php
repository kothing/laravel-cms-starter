<!-- Select2 CSS -->
@push('after-styles')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush

<!-- Select2 JS -->
@push('after-scripts')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script type="module">
    $(document).ready(function() {
        if($('.select2').length > 0) {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select an option',
            });
        }
    });
</script>
@endpush