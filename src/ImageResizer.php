<?php

namespace Quinlan\ImageResizer;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageResizer
{
    public string $directoryName;
    private string $disk;
    private array $fileTypes;
    private array $Sizes;

    public function __construct()
    {
        $this->directoryName = uniqid();
        $this->disk = config('imageResizer.disk');
        $this->fileTypes = config('imageResizer.image_type_array');
        $this->Sizes = config('imageResizer.sizes');
    }

    public function upload(string $image)
    {
        try {
            $image = request()->file($image);
            $imageSize = getimagesize($image);
            $fileExt = $image->extension();

            if(!in_array($fileExt,$this->fileTypes)) throw new \ErrorException('Invalid File Type');

            $originalFile = 'original.'.$fileExt;
            $uploaded = $image->storeAs(
                $this->directoryName, //folder
                $originalFile, //name
                $this->disk //disk
            );
            $storage = Storage::disk($this->disk);
            $img = Image::make($image);

            foreach ($this->Sizes as $size) {
                if(!$size["width"] && !is_int($size["width"])) throw new \ErrorException('Width cannot be null or empty! it must be integer!');
                if($imageSize[0] > $size["width"])
                {
                    $img->resize($size["width"], $size["height"], function ($constraint) use ($size) {
                        if($size["aspectRatio"]) $constraint->aspectRatio();
                    });
                    $img->save();
                    $storage->put(
                        $this->directoryName.'/'.$this->directoryName.'_'.$size["width"].'.'.$fileExt,
                        $img
                    );
                }
            }

            return (object) [
                'directory' => $this->directoryName,
                'path' => $storage->path($uploaded),
                'url' => $storage->url($uploaded)
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function setSizes(array $sizes) : self
    {
        $this->Sizes = $sizes;

        return $this;
    }

    public function setName(string $name) : self
    {
        if($name) $this->directoryName = $name;

        return $this;
    }

    public function setFileTypes(array $types) : self
    {
        $this->fileTypes = $types;

        return $this;
    }

    public function disk(string $disk) : self
    {
        $this->disk = $disk;

        return $this;
    }
}
