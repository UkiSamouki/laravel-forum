<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Chanel as Chanel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view){

            $chanels = \Cache::rememberForever('chanels', function() {

                return Chanel::all();
            });
            $view->with('chanels', $chanels);
        });
        //\View::share('chanels', \App\Chanel::all());//this runs before migrations

    }
}
