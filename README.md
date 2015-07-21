# uploader
Front end image cropping and editing with Cropper JS and Plupload for Laravel.

**Note**

> This is still in testing. This will be published to a package once testing is complete.

```php
    @include('partials.uploader.ui', [
        'name' => 'cropper',
        'width' => 500,
        'height' => 500,
        'upload_url' => url('upload'),
        'max_file_size' => '5mb',
        'allowed_extensions' => 'jpg,gif,png',
        'flash_swf_url' => asset('js/vendor/plupload/Moxie.swf'),
        'silverlight_xap_url' => asset('js/vendor/plupload/Moxie.xap'),
        'onPostInit' => '',
        'onFileAdded' => '',
        'onBeforeUpload' => '',
        'onFileUploaded' => '',
        'onUploadProgress' => '',
        'onError' => '',
    ])
```

**Options**

*name* will be the name of the hidden input which stores all uploaded file names as a JSON array.