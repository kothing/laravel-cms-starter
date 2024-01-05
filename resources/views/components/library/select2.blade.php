@push('after-styles')
<link href="https://unpkg.com/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
@endpush

@push('after-scripts')
<script type="module" src="https://unpkg.com/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="module">
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Select an option --',
        });
    });
</script>
@endpush