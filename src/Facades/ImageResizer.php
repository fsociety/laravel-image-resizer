<?php

namespace Quinlan\ImageResizer\Facades;

use Illuminate\Support\Facades\Facade;
use Quinlan\ImageResizer\ImageResizer as IRes;

class ImageResizer extends Facade
{

    protected static function getFacadeAccessor()
    {
        return IRes::class;
    }

}
