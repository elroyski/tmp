<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class MonthlyStatsController extends Controller
{
    public function index(Request $request, $year = null, $month = null)
    {
        if ($year && $month) {
            $date = Carbon::createFromDate($year, $month, 1);
        } else {
            $monthYear = $request->input('month-year', Carbon::now()->format('Y-m'));
            [$year, $month] = explode('-', $monthYear);
            $date = Carbon::createFromDate($year, $month, 1);
        }

        $startDate = $date->copy()->startOfMonth()->format('Y-m-d');
        $endDate = $date->copy()->endOfMonth()->format('Y-m-d');

        $previousMonth = $date->copy()->subMonth()->format('Y/m');
        $nextMonth = $date->copy()->addMonth()->format('Y/m');

        // Klucz cache
        $cacheKey = "monthly_stats_{$year}_{$month}";
        $cacheTime = 60 * 60 * 24 * 30; // Około 30 dni

        $stats = Cache::remember($cacheKey, $cacheTime, function () use ($startDate, $endDate) {
            return DB::table('raporty_empiku')
                    ->whereBetween('data', [$startDate, $endDate])
                    ->select('ean', 'nazwa_indeksu', DB::raw('sum(ilosc_sztuk_s) as ilosc'))
                    ->groupBy('ean', 'nazwa_indeksu')
                    ->orderBy('ilosc', 'desc')
                    ->get();
        });

        $monthlyTotal = $stats->sum('ilosc');

        return view('monthly-stats', [
            'stats' => $stats,
            'date' => $date,
            'previousMonth' => $previousMonth,
            'nextMonth' => $nextMonth,
            'monthlyTotal' => $monthlyTotal
        ]);
    }
}