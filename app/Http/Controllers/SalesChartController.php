<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Carbon\Carbon;


class SalesChartController extends Controller
{
    public function getSalesData($month = null, $year = null)
    {
        $currentMonth = $month ?? Carbon::now()->month;
        $currentYear = $year ?? Carbon::now()->year;

        $startOfMonth = Carbon::now()->subMonths(1)->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Klucz cache i czas trzymania danych (np. 24 godziny)
        $cacheKey = "sales_data_{$currentYear}_{$currentMonth}";
        $cacheTime = 60 * 60 * 24; // 1 dzień

        $salesData = Cache::remember($cacheKey, $cacheTime, function () use ($startOfMonth, $endOfMonth) {
            return DB::table('raporty_empiku')
                    ->whereBetween('data', [$startOfMonth, $endOfMonth])
                    ->groupBy('data')
                    ->selectRaw('date(data) as date, sum(ilosc_sztuk_s) as sumIloscSztuk')
                    ->get();
        });

        return $salesData;
    }
}