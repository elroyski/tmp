<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatsReport;
use App\Mail\StatsReportLight;
use App\Mail\EmpikComReportMail;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
class DailyStatsController extends Controller

{
    public function index(Request $request, $date = null)
    {
        if (!$date) {
            $date = $request->input('date', Carbon::yesterday()->format('Y-m-d'));
        }
        $date = Carbon::createFromFormat('Y-m-d', $date);

        $previousDay = $date->copy()->subDay()->format('Y-m-d');
        $nextDay = $date->copy()->addDay()->format('Y-m-d');

        // Klucz cache
	$cacheKey = 'daily_stats_' . $date->format('Y-m-d');
        // Czas życia cache (w sekundach), np. 24 godziny
        $cacheTime = 60 * 60 * 24 * 30;

        $stats = Cache::remember($cacheKey, $cacheTime, function () use ($date) {
            return DB::table('raporty_empiku')
                ->whereDate('data', $date)
                ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilość'))
                ->groupBy('ean', 'nazwa_indeksu')
                ->orderBy('ilość', 'desc')
                ->get();
        });

        $dailyTotal = Cache::remember($cacheKey . '_total', $cacheTime, function () use ($date) {
            return DB::table('raporty_empiku')
                ->whereDate('data', $date)
                ->sum('ilosc_sztuk_s');
        });

        return view('daily-stats', compact('stats', 'date', 'previousDay', 'nextDay', 'dailyTotal'));
    }
	
	//  wysylanie maili
	
public function sendEmailWithStats($date = null)
{
	$kierownicyEmails = User::where('group', 'Kierownik')->pluck('email')->toArray();
    $pracownicyEmails = User::where('group', 'Pracownik')->pluck('email')->toArray();

	Log::info('Adresy e-mail kierowników:', $kierownicyEmails);
	Log::info('Adresy e-mail pracowników:', $pracownicyEmails);



    $date = $date ?: Carbon::yesterday()->format('Y-m-d');
    $date = Carbon::createFromFormat('Y-m-d', $date);
    $monthStart = $date->copy()->startOfMonth()->format('Y-m-d');
    $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d');

    // Pobieranie danych dziennych bez wartości == 0
    $dailyStats = DB::table('raporty_empiku')
        ->whereDate('data', $date)
        ->where('ilosc_sztuk_s', '>', 0) // Dodaj warunek, aby ilość była większa od zera
        ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilość'))
        ->groupBy('ean', 'nazwa_indeksu')
        ->orderBy('ilość', 'desc')
        ->get();

    // Pobieranie danych miesięcznych bez wartości == 0
    $monthlyStats = DB::table('raporty_empiku')
        ->whereBetween('data', [$monthStart, $monthEnd])
        ->where('ilosc_sztuk_s', '>', 0) // Dodaj warunek, aby ilość była większa od zera
        ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilość'))
        ->groupBy('ean', 'nazwa_indeksu')
        ->orderBy('ilość', 'desc')
        ->get();

    $dailyTotal = $dailyStats->sum('ilość');
    $monthlyTotal = $monthlyStats->sum('ilość');
	$dailyTop20 = $dailyStats->take(20);

	

    
   //  Sprawdzanie czy są dane
	

// Sprawdzanie czy są dane
	if ($dailyStats->isEmpty() && $monthlyStats->isEmpty()) {
		// Email informacyjny o braku danych wysyłany na stały adres
		Mail::to('tomasz.wojcik@wsqn.pl')->send(new StatsReport(null, null, $date, true));
	} else {
		// Raport z danymi wysyłany do wszystkich kierowników
		
			foreach ($kierownicyEmails as $email) {
			Mail::to($email)->send(new StatsReport($dailyStats, $monthlyStats, $date, false, $dailyTotal, $monthlyTotal));
			sleep(2); // Opóźnienie 1 sekundy
		}

			foreach ($pracownicyEmails as $email) {
			Mail::to($email)->send(new StatsReportLight($dailyTop20, $date));
			sleep(2); // Opóźnienie 1 sekundy
}

	}


}


public function sendEmpikComReport($date = null)
{
    $date = $date ?: Carbon::yesterday()->format('Y-m-d');
    $dateObject = Carbon::createFromFormat('Y-m-d', $date);
    $kierownicyEmails = User::where('group', 'Kierownik')->pluck('email')->toArray();

    // Pobieranie danych specyficznych dla Empik.com
    $dailyStats = DB::table('raporty_empiku')
        ->whereDate('data', $date)
        ->where('store_id', 70401)
        ->where('ilosc_sztuk_s', '>', 0)
        ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilość'))
        ->groupBy('ean', 'nazwa_indeksu')
        ->orderBy('ilość', 'desc')
        ->get();

    $monthlyStats = DB::table('raporty_empiku')
        ->whereBetween('data', [Carbon::parse($date)->startOfMonth(), Carbon::parse($date)->endOfMonth()])
        ->where('store_id', 70401)
        ->where('ilosc_sztuk_s', '>', 0)
        ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilość'))
        ->groupBy('ean', 'nazwa_indeksu')
        ->orderBy('ilość', 'desc')
        ->get();

    $dailyTotal = $dailyStats->sum('ilość');
    $monthlyTotal = $monthlyStats->sum('ilość');

    // Sprawdzanie czy są dane
    if ($dailyStats->isEmpty() && $monthlyStats->isEmpty()) {
        Mail::to('tomasz.wojcik@wsqn.pl')->send(new StatsReport(null, null, $dateObject, true));
    } else {
        foreach ($kierownicyEmails as $email) {
		Mail::to($email)->send(new EmpikComReportMail($dailyStats, $monthlyStats, $dateObject, $dailyTotal, $monthlyTotal));
            // Opóźnienie między wysyłaniem e-maili
            sleep(2);
        }
    }

    Log::info('Raport Empik.com wysłany do kierowników.');
}

	
	
	
}
