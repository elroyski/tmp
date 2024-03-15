<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TopStoresController extends Controller
{
    public function index($year = null)
    {
        $year = $year ?? Carbon::now()->year;

        // Klucz cache i czas życia (np. 30 dni)
        $cacheKey = "top_stores_{$year}";
        $cacheTime = 60 * 60 * 24 * 365; // Około 1 rok

        $topStores = Cache::remember("{$cacheKey}_topStores", $cacheTime, function () use ($year) {
            return DB::table('raporty_empiku')
                    ->whereYear('data', $year)
                    ->select('store_id', 'site_name', DB::raw('SUM(ilosc_sztuk_s) as ilosc'))
                    ->groupBy('store_id', 'site_name')
                    ->orderBy('ilosc', 'desc')
                    ->get();
        });

        // Obliczenie sumy dla Empik.com
        $empikTotal = Cache::remember("{$cacheKey}_empikTotal", $cacheTime, function () use ($year) {
            return DB::table('raporty_empiku')
                    ->whereYear('data', $year)
                    ->where('store_id', 70401)
                    ->sum('ilosc_sztuk_s');
        });

        // Obliczenie sumy dla innych salonów
        $otherStoresTotal = Cache::remember("{$cacheKey}_otherStoresTotal", $cacheTime, function () use ($year) {
            return DB::table('raporty_empiku')
                    ->whereYear('data', $year)
                    ->where('store_id', '!=', 70401)
                    ->sum('ilosc_sztuk_s');
        });

        $previousYear = $year - 1;
        $nextYear = $year + 1;

        return view('top-stores', compact('topStores', 'year', 'previousYear', 'nextYear', 'empikTotal', 'otherStoresTotal'));
    }
}
