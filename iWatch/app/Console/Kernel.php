<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;

use App\Models\UserSubscription;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    // Funcion para programar la comprobación de la suscripcion del usuario
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $today = Carbon::today('Europe/Madrid');
            // Obtener registros cuya fecha de finalización coincide con la fecha de hoy
            $subscriptions = UserSubscription::whereDate('end_date', $today)->get();
            // Log de la cantidad de registros encontrados
            Log::info('Se encontraron ' . $subscriptions->count() . ' registros con fecha de finalización de hoy.');
            // Eliminar registros
            $deleted = UserSubscription::whereDate('end_date', $today)->delete();
            // Log de la cantidad de registros eliminados
            Log::info('Se eliminaron ' . $deleted . ' registros con fecha de finalización de hoy.');
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
