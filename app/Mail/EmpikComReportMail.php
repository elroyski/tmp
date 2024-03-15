<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class EmpikComReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dailyStats, $monthlyStats, $date, $dailyTotal, $monthlyTotal;

    public function __construct($dailyStats, $monthlyStats, Carbon $date, $dailyTotal, $monthlyTotal)
    {
        $this->dailyStats = $dailyStats;
        $this->monthlyStats = $monthlyStats;
        $this->date = $date;
        $this->dailyTotal = $dailyTotal;
        $this->monthlyTotal = $monthlyTotal;
    }

    public function build()
    {
	 $subject = 'Raporty Empik.com ' . $this->date->format('Y-m-d') . ' -  ' . $this->dailyTotal . ' / ' . $this->monthlyTotal;	
	 return $this->view('emails.empikcom_report')
					
                    ->subject($subject)
					->with([
                        'dailyStats' => $this->dailyStats,
                        'monthlyStats' => $this->monthlyStats,
                        'date' => $this->date,
                        'dailyTotal' => $this->dailyTotal,
                        'monthlyTotal' => $this->monthlyTotal,
                    ]);
    }
}
