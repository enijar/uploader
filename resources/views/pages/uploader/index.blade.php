@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @include('partials.uploader.ui', [
                'name' => 'cropper',
                'width' => 1500,
                'height' => 1500,
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
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @include('partials.uploader.ui', [
                'name' => 'cropper_2',
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
        </div>
    </div>
@endsection