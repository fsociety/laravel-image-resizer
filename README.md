
# Image Resizer

a simple laravel package that creates different versions of an image so you can show your images based on screen

## Installation

set your composer.json

```json
  {
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/fsociety/laravel-image-resizer.git"
        }
    ],
    "require": {
        "quinlan/image-resizer": "dev-master"
    }
}
```

and run this
```bash
  php artisan vendor:publish --tag=image_resizer_config
```

## Integration

before using, make your own settings in **config/imageResizer.php**

then you need to post image

```html
<form action="" method="POST" enctype="multipart/form-data">
  @csrf
  <label for="formFile">Image</label>
  <input type="file" name="image" id="formFile">
  <button type="submit">Submit</button>
</form>
```

***upload()*** method gets only one parameter that is name of file input. 

```php
  use Quinlan\ImageResizer\Facades\ImageResizer;

  $image = ImageResizer::upload('image');
```

you can change your settings before upload
```php
  use Quinlan\ImageResizer\Facades\ImageResizer;

  $image = ImageResizer::disk('public')
              ->setFileTypes(['jpg','png'])
              ->setSizes([
                  [
                      'width' => 720,
                      'height' => 1280,
                      'aspectRatio' => true
                  ],
                  [
                      'width' => 480,
                      'height' => 800,
                      'aspectRatio' => true
                  ]
              ])
              ->setName('customName') // if empty, name will be randomly generated
              ->upload('image');
```
*these methods are optional except upload() method*

---
\
ImageResizer::upload returns and object, so in that case $image variable is an object

```json
{
  // $image
  +"directory": "638334a5c5b68"
  +"path": "<your-path>/638334a5c5b68/original.jpg"
  +"url": "/uploads/638334a5c5b68/original.jpg"
}
```

you can use this object with helpers

## Helpers

helpers are global and you can use them everywhere in application

### resizedImages()
this helper gets two parameter. first parameter must be directory name or file name, and second parameter is disk. disk is an optional parameter
```php
  resizedImages('638334a5c5b68','public');
```
this method returns an array of files

### getPictures()
this helper gets same paramater with resizedImages() but returns html code.
```php
  getPictures('638334a5c5b68','public');
```
alternative versions of an image for different screens

---

### to see example
- go to http://{your-host.test}/image-resizer/test

## Running Tests

To run tests, run the following command

```bash
  php artisan test vendor/quinlan/image-resizer
```

