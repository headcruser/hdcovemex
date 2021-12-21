<?php

namespace HelpDesk\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class CarbonServiceProvider extends ServiceProvider
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
         # OBTIENE LOS MESES DEL AÑO
         Carbon::macro('getMonthsOfYear', function () {
            $meses = [];

            foreach (range(1, 12) as $month) {
                $meses[$month] = ucfirst(Carbon::now()->month($month)->monthName);
            }

            return $meses;
        });

        # OBTIENE UNA LISTA DE AÑOS
        Carbon::macro('getLastYears',function(int $last = 3,int $add = 0){
            $list = [];

            if($last == 0 || $last < 0){
                return $list;
            }

            $rango_anios = range(Carbon::now()->subYear($last)->year ,Carbon::now()->addYear($add)->year );
            $list = array_combine($rango_anios, $rango_anios);

            return $list;
        });
    }
}
