<?php

namespace HelpDesk\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         # NOMBRE DE VISTAS BLADE
         view()->composer('*', function($view){

            $current_view = $view->getName();
            $array_name_view = explode('.', $current_view);
            $view_name = end( $array_name_view );

            view()->share('view_name', $view_name );
        });
    }
}
