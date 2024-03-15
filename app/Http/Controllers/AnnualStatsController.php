<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AnnualStatsController extends Controller
{
    public function index()
    {
		
	$currentYear = Carbon::now()->year;
    $previousYear = $currentYear - 1;
	$cacheKey = "annual_stats_{$currentYear}_{$previousYear}";
    $cacheTime = 60 * 60 * 24 * 30 * 365; // Czas życia cache, np. 30 dni
	
		
		$stats = Cache::remember($cacheKey, $cacheTime, function () use ($previousYear, $currentYear) {
        return DB::table('raporty_empiku')
                ->select(
                    DB::raw('YEAR(data) as rok'),
                        DB::raw('MONTH(data) as miesiac'),
                        DB::raw('SUM(ilosc_sztuk_s) as ilosc'),
                        DB::raw('SUM(SUM(ilosc_sztuk_s)) OVER (PARTITION BY YEAR(data) ORDER BY YEAR(data), MONTH(data)) as ilosc_narastajaco')
                    )
                    ->groupBy('rok', 'miesiac')
                    ->orderBy('rok', 'desc')
                    ->orderBy('miesiac', 'desc')
                    ->get();

		  });	

        return view('annual-stats', compact('stats'));
    }
}
