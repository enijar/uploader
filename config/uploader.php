<?php

return [

    'max_file_size' => '5mb',
    'allowed_extensions' => 'jpg,gif,png',
    'upload_url' => url('upload'),
    'flash_swf_url' => asset('js/vendor/plupload/Moxie.swf'),
    'silverlight_xap_url' => asset('js/vendor/plupload/Moxie.xap'),
    'uploader_css_url' => asset('assets/css/image_preview.css'),
    'cropper_css_url' => asset('assets/css/cropper.min.css'),
    'uploader_js_url' => asset('assets/js/vendor/plupload/plupload.min.js'),
    'cropper_js_url' => asset('assets/js/vendor/cropper.min.js'),

];