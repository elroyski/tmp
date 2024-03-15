<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class StatsReportLight extends Mailable
{
    use Queueable, SerializesModels;

    public $dailyTop20, $date;

    /**
     * Utwórz nową instancję wiadomości.
     *
     * @param  Collection  $dailyTop20 Kolekcja zawierająca dane top 20 sprzedaży dziennej.
     * @param  Carbon  $date Data, dla której przygotowywany jest raport.
     */
    public function __construct($dailyTop20, Carbon $date)
    {
        $this->dailyTop20 = $dailyTop20;
        $this->date = $date;
    }

    /**
     * Buduj wiadomość.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.stats_report_light')
                    ->subject('Raport Top 20 Sprzedaży Dziennej - ' . $this->date->format('Y-m-d'))
                    ->with([
                        'dailyTop20' => $this->dailyTop20,
                        'date' => $this->date,
                    ]);
    }
}
