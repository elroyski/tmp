<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    protected function schedule(Schedule $schedule)
    {
    
 // odkomentowac gdyby trzeba bylo odpalac za kazdym razem kolejke w Elibri    
 // $schedule->command('logcronentry')->everyMinute();
 // $schedule->command('elibri:refill-queue')
 //        ->dailyAt('15:38');


       $schedule->command('display:books-metadata') //nazwa mylaca, to import nie display - do zmiany. task importuje nowe ksiazki z elibir do bazy
	->dailyAt('18:00');
	    
    
       $schedule->command('import:email-attachments') //pibranie zalacznika z raportu empik i jego importu
        ->dailyAt('11:37');
        
        $schedule->command('send:stats-email') //wysyłanie ogólnych statystyk sprzedaży 
		->dailyAt('11:47');
         
		 $schedule->command('send:empikcom-report') //wysyłanie statystyk empik.com
		->dailyAt('11:47');	
	   
		$schedule->command('report:send-inventory') //wysyłanie zestawienia magazynowego
		->dailyAt('11:48');	
    }


    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

}
