<?php

namespace Quinlan\ImageResizer\Controllers;

use Illuminate\Http\Request;
use Quinlan\ImageResizer\Facades\ImageResizer;

class ImageResizerController
{
    public function index(Request $request)
    {
        if($request->isMethod('POST')){
            $image = ImageResizer::upload('image');
        }

        return view('image-resizer::test',[
            'image' => $image ?? null
        ]);
    }
}
