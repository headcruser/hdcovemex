<?php

namespace HelpDesk\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::setLocale(getLocale());


        # VERBOS DE RUTAS
        Route::resourceVerbs([
            'create'    => 'crear',
            'edit'      => 'editar',
        ]);

        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
