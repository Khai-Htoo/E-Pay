<?php

namespace App\Providers;


use Illuminate\Support\Facades;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();



        Facades\View::composer('*', function (View $view) {
            $notiCount = 0;

            if(Auth::user()){
                $notiCount = Auth::user()->unreadNotifications->count();
            }
            $view->with('count', $notiCount);
        });

    }
}
