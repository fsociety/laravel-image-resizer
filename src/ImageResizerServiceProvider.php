<?php

namespace Quinlan\ImageResizer;

use Illuminate\Support\ServiceProvider;

class ImageResizerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ImageResizer.php' => config_path('imageResizer.php')
        ],'image_resizer_config');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'image-resizer');
    }

    public function register()
    {
        $this->app->singleton(ImageResizer::class, function(){
            return new ImageResizer();
        });
    }
}
