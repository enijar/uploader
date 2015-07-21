<link rel="stylesheet" href="{{ config('uploader.uploader_css_url') }}">
<link rel="stylesheet" href="{{ config('uploader.cropper_css_url') }}">

<script type="text/html" id="image_preview_template">
    @include('partials.uploader.templates.uploader_preview')
</script>

<script src="{{ config('uploader.uploader_js_url') }}"></script>
<script src="{{ config('uploader.cropper_js_url') }}"></script>

<script>
    var showImgPreview = function(width, height, name, file, index, url, uploader) {
        var explanation = 'You image will be cropped to <strong>' + width + 'px</strong> by <strong>' + height + 'px</strong>';
        var container = $('#' + name + '_preview');
        var template = $('#image_preview_template').html();
            template = template.split('{id}').join(file.id);
            template = template.split('{src}').join(url);
            template = template.split('{explanation}').join(explanation);

        container.append(template);

        var $image = $('#' + file.id + '_cropper');
        var canvasData = {width: width, height: height};
        var containerData = {width: 568, height: 568};
        var cropBoxData = {rotate: 0};
        var scaled = {
            width: (100/canvasData.width)*containerData.width,
            height: (100/canvasData.height)*containerData.height
        };

        $(document).on('click', '#' + file.id + '_remove', function() {
            delete window[name + '_files'][file.id];
            uploader.splice(index, 1);
            document.getElementById(file.id).remove();

            var input = $('#' + name + '_input');
            var files = JSON.parse(input.val());

            files.splice(index, 1);
            input.val(JSON.stringify(files));
        });

        window[name + '_files'][file.id] = {
            _token: '{{ csrf_token() }}',
            canvas_width: canvasData.width,
            canvas_height: canvasData.height,
            file_id: file.id
        };

        $('#' + file.id + '_modal').on('shown.bs.modal', function() {
            $image.cropper({
                aspectRatio: scaled.width / scaled.height,
                guides: false,
                dragCrop: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                built: function() {
                    $image.cropper('getContainerData', containerData);
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                },
                crop: function(data) {
                    window[name + '_files'][file.id] = {
                        _token: '{{ csrf_token() }}',
                        canvas_width: canvasData.width,
                        canvas_height: canvasData.height,
                        x: Math.round(data.x),
                        y: Math.round(data.y),
                        width: Math.round(data.width),
                        height: Math.round(data.height),
                        rotate: Math.round(data.rotate)
                    };
                }
            }).on('hidden.bs.modal', function() {
                containerData = $image.cropper('getContainerData');
                canvasData = $image.cropper('getCanvasData');
                cropBoxData = $image.cropper('getCropBoxData');
                $image.cropper('destroy');
            });
        });
    };
</script>