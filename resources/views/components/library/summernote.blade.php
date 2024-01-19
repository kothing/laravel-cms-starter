<!-- Summernote editor && File Manager -->
@push('after-styles')
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/lfm.css') }}">
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
    // Define function to open filemanager window
    const fileOpen = function(options, cb) {
        const route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };

    // Define LFM summernote button
    const FileButton = function(context) {
        const ui = $.summernote.ui;
        const button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Insert image with filemanager',
            click: function() {
                fileOpen({
                    type: 'image',
                    prefix: '/filemanager'
                }, function(lfmItems, path) {
                    lfmItems.forEach(function(lfmItem) {
                        context.invoke('insertImage', lfmItem.url);
                    });
                });

            }
        });
        return button.render();
    };

    $('#content').summernote({
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['fontname', 'fontsize', 'bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'lfm', 'video']],
            ['view', ['codeview', 'undo', 'redo', 'help']],
        ],
        buttons: {
            lfm: FileButton
        }
    });
</script>
@endpush