<div class="row">
    <div class="col-xs-12">
        <div id="{{ $name }}_preview" class="preview-wrapper"></div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <input type="hidden" name="{{ $name }}" id="{{ $name }}_input" value="">
        <button id="{{ $name }}_browse" class="btn btn-primary">Browse Files</button>
        <button id="{{ $name }}_upload" class="btn btn-success">Upload Files</button>
    </div>
</div>

<script>
    window.{{ $name }}_files = {};

    var {{ $name }}_uploader = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        browse_button: '{{ $name }}_browse',
        url: '{{ $upload_url or config('uploader.upload_url') }}',
        multipart_params: {},
        filters: {
            max_file_size: '{{ $max_file_size or '5mb' }}',
            mime_types: [
                {title: "Allowed files", extensions: '{{ $allowed_extensions or config('uploader.allowed_extensions') }}'}
            ]
        },
        flash_swf_url: '{{ $flash_swf_url or config('uploader.flash_swf_url') }}',
        silverlight_xap_url: '{{ $silverlight_xap_url or config('uploader.silverlight_xap_url') }}',
        init: {
            PostInit: function(up) {
                $('#{{ $name }}_input').val(JSON.stringify([]));

                $(document).on('click', '#{{ $name }}_upload', function() {
                    {{ $name }}_uploader.start();
                    return false;
                });

                @if(isset($onPostInit) && !empty($onPostInit))
                    {{ "{$onPostInit}(up)" }}
                @endif
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file, index) {
                    var image = new Image();
                    var preloader = new mOxie.Image();

                    preloader.onload = function() {
                        image.src = preloader.getAsDataURL();
                        showImgPreview({{ $width }}, {{ $height }}, '{{ $name }}', file, index, preloader.getAsDataURL(), {{ $name }}_uploader);
                    };

                    preloader.load(file.getSource());
                });

                @if(isset($onFileAdded) && !empty($onFileAdded))
                    {{ "{$onFileAdded}(up, files)" }}
                @endif
            },
            BeforeUpload: function(up, file) {
                $('#' + file.id).find('.btn-container').remove();
                {{ $name }}_uploader.settings.multipart_params = {{ $name }}_files[file.id];

                @if(isset($onBeforeUpload) && !empty($onBeforeUpload))
                    {{ "{$onBeforeUpload}(up, file)" }}
                @endif
            },
            FileUploaded: function(up, file, response) {
                var json = JSON.parse(response.response);

                if(json.status === 'ok') {
                    var input = $('#{{ $name }}_input');
                    var files = input.val();
                    var filesJson = JSON.parse(files);

                    filesJson.push(json.file.name);
                    input.val(JSON.stringify(filesJson));
                } else {
                    console.log(json.status);
                }

                $('#' + json.file.id + '_progress').parent().remove();

                @if(isset($onFileUploaded) && !empty($onFileUploaded))
                    {{ "{$onFileUploaded}(up, file, response)" }}
                @endif
            },
            UploadProgress: function(up, file) {
                $('#' + file.id + '_progress').css({width: file.percent + '%'});

                @if(isset($onUploadProgress) && !empty($onUploadProgress))
                    {{ "{$onUploadProgress}(up, file)" }}
                @endif
            },
            Error: function(up, error) {
                @if(isset($onError) && !empty($onError))
                    {{ "{$onError}(up, error)" }}
                @endif
            }
        }
    });

    {{ $name }}_uploader.init();
</script>