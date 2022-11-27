<?php

use Illuminate\Support\Facades\Storage;

function resizedImages(string $directory, ?string $disk = null) : array{
    $disk = $disk ?? config('imageResizer.disk');
    $storage = Storage::disk($disk);
    if(isset(pathinfo($directory)['extension']))
    {
        $directory = pathinfo(dirname($storage->path($directory)))["basename"];
    }
    $images = $storage->files($directory);
    $images = array_map(function($val) use ($storage){
        $imginfo = getimagesize($storage->path($val));
        return [
            'url' => $storage->url($val),
            'width' => $imginfo[0],
            'height' => $imginfo[1]
        ];
    },$images);
    return $images;
}

function getPictures(string $directory, ?string $disk = null) : string
{
    $html = '<picture style="max-width:100%">';
    $images = resizedImages($directory,$disk);
    $original = array_pop($images);
    foreach ($images as $img) {
        $html .= '<source media="(max-width:'.$img["width"].'px)" srcset="'.$img['url'].'">';
    }
    $html .= '<img src="'.$original["url"].'" style="width:auto; max-width:100%;">';
    $html .= '</picture>';

    return $html;
}
