<?php

Route::get('/', 'UploadController@index');
Route::post('upload', 'UploadController@store');