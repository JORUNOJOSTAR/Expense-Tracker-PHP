<?php

namespace App\Providers;

use App\Services\FileService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileService::class,function($app){
            return new FileService();
        });
    }
}
