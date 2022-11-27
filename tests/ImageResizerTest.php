<?php

namespace Tests;

use Quinlan\ImageResizer\Facades\ImageResizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageResizerTest extends TestCase
{

    public function getMockImage()
    {
        $storage = Storage::fake('uploads');

        $file = UploadedFile::fake()->image('image.jpg', 3840, 2160)->size(500);

        $this->post('/', [
            'image' => $file,
        ]);

        $image = ImageResizer::upload('image');

        return [
            'storage' => $storage,
            'image' => $image
        ];
    }

    public function testUpload()
    {
        extract($this->getMockImage());

        $this->assertIsObject($image);
        $this->assertObjectHasAttribute('directory',$image);
        $this->assertObjectHasAttribute('path',$image);
        $this->assertObjectHasAttribute('url',$image);
        $this->assertTrue($storage->exists($image->directory));
        $this->assertFileExists($image->path);
    }

    public function testResizedImagesHelper()
    {
        extract($this->getMockImage());

        $resizedImages = resizedImages($image->directory);

        $this->assertIsArray($resizedImages);
        foreach ($resizedImages as $key => $value) {
            $this->assertIsArray($value);
            $this->assertIsString($value["url"]);
            $this->assertIsInt($value["width"]);
            $this->assertIsInt($value["height"]);
        }
    }

    public function testGetPicturesHelper()
    {
        extract($this->getMockImage());

        $this->assertIsString($image->directory);
    }
}
