<?php

Route::get('/', 'UploaderController@index');
Route::post('upload', 'UploaderController@store');