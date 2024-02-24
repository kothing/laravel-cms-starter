<!-- Summernote editor && File Manager -->
@push('after-styles')
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.min.css') }}">
<style>
    .note-editor.note-frame :after {
        display: none;
    }
    .note-editor .note-toolbar .note-dropdown-menu,
    .note-popover .popover-content .note-dropdown-menu {
        min-width: 180px;
    }
</style>
@endpush

@push('after-scripts')
<script src="{{ asset('vendor/summernote/summernote-lite.min.js') }}"></script>
<script type="module">
    $('#content').summernote({
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['fontname', 'fontsize', 'bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview', 'undo', 'redo', 'help']],
        ],
    });
</script>
@endpush