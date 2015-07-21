<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use stdClass;
use Validator;

class UploaderController extends Controller
{
    /**
     * Uploads any valid image with a random file name to the uploads
     * directory. If the image is invalid then an "invalid_file"
     * status is returned, else an "ok" status is returned.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'image']);

        if($validator->fails())
        {
            return ['status' => 'invalid_file', 'file' => null];
        }

        $file = $request->file('file');
        $name = str_random(16).".{$file->getClientOriginalExtension()}";
        $path = public_path("uploads/{$name}");
        $file->move(public_path('uploads'), $name);

        $img = \Image::make($path);
        $cropData = $this->getCropData($img, $request);

        if(is_null($request->get('width')))
        {
            $img->fit($request->get('canvas_width'), $request->get('canvas_height'));
        }
        else
        {
            $img->crop($cropData->width, $cropData->height, $cropData->x, $cropData->y);
            $img->rotate($cropData->rotate);
            $img->resize($cropData->canvas_width, $cropData->canvas_height);
        }

        $img->save($path, 100);

        return ['status' => 'ok', 'file' => [
            'id' => $request->get('file_id'),
            'name' => $name
        ]];
    }

    /**
     * Check if the crop data has been sent in the request. If so the
     * data is added to the $cropData object, else it is reverted
     * to the image defaults.
     *
     * @param $img
     * @param Request $request
     * @return stdClass
     */
    private function getCropData($img, Request $request)
    {
        $cropData = new StdClass;
        $cropData->x = (int) is_null($request->get('x')) ? 0 : $request->get('x');
        $cropData->y = (int) is_null($request->get('y')) ? 0 : $request->get('y');
        $cropData->width = (int) is_null($request->get('width')) ? $img->getWidth() : $request->get('width');
        $cropData->height = (int) is_null($request->get('height')) ? $img->getHeight() : $request->get('height');
        $cropData->canvas_width = (int) is_null($request->get('canvas_width')) ? $cropData->width : $request->get('canvas_width');
        $cropData->canvas_height = (int) is_null($request->get('canvas_height')) ? $cropData->height : $request->get('canvas_height');
        $cropData->rotate = (int) is_null($request->get('rotate')) ? 0 : $request->get('rotate');

        return $cropData;
    }
}
