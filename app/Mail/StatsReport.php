<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class StatsReport extends Mailable
{
    use Queueable, SerializesModels;

    public $dailyStats, $monthlyStats, $date, $isDataMissing, $dailyTotal, $monthlyTotal;

    public function __construct($dailyStats, $monthlyStats, Carbon $date, $isDataMissing = false, $dailyTotal = 0, $monthlyTotal = 0)
    {
        $this->dailyStats = $dailyStats;
        $this->monthlyStats = $monthlyStats;
        $this->date = $date;
        $this->isDataMissing = $isDataMissing;
        $this->dailyTotal = $dailyTotal;
        $this->monthlyTotal = $monthlyTotal;
    }
	

	
	
    public function build()
    {
        $subject = 'Raporty Empik ' . $this->date->format('Y-m-d') . ' -  ' . $this->dailyTotal . ' / ' . $this->monthlyTotal;
        return $this->view('emails.stats_report')
                    ->subject($subject)
                    ->with([
                        'dailyStats' => $this->dailyStats,
                        'monthlyStats' => $this->monthlyStats,
                        'date' => $this->date,
                        'isDataMissing' => $this->isDataMissing,
                        'dailyTotal' => $this->dailyTotal,
                        'monthlyTotal' => $this->monthlyTotal
                    ]);
    }
}



