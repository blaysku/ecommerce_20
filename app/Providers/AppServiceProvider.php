<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormMaker;
use App\Services\ViewShare;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FormMaker::boot();
        ViewShare::boot();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
