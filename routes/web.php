<?php

use Illuminate\Support\Facades\Route;
use Quinlan\ImageResizer\Controllers\ImageResizerController;

Route::match(['get','post'],'/image-resizer/test', [ImageResizerController::class,'index']);
