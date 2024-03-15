<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use DB;
use Carbon\Carbon;

class TopAuthorsController extends Controller
{
    // Metoda dla raportu miesięcznego
    public function index($year = null, $month = null)
    {
      
	     // Ustawienie daty na początek bieżącego miesiąca, jeśli parametry nie są podane
    $date = $year && $month ? Carbon::createFromDate($year, $month, 1) : Carbon::now()->startOfMonth();
    $startDate = $date->format('Y-m-d');
    $endDate = $date->endOfMonth()->format('Y-m-d');

    // Obliczanie poprzedniego i następnego miesiąca zaczynając od początku miesiąca
    // Używamy subMonthNoOverflow() zamiast subMonth() aby uniknąć problemów z różną liczbą dni w miesiącach
    $previousMonth = $date->copy()->subMonthNoOverflow()->startOfMonth()->format('Y/m');
    $nextMonth = $date->copy()->addMonthNoOverflow()->startOfMonth()->format('Y/m');

	  
	  
        $cacheKey = "top_authors_monthly_{$startDate}_{$endDate}";
        $cacheTime = 60 * 60 * 24 * 365; // Około 1 rok

        $topAuthors = Cache::remember($cacheKey, $cacheTime, function () use ($startDate, $endDate) {
            return DB::table('raporty_empiku')
                ->join('books', 'raporty_empiku.ean', '=', 'books.ean')
                ->select('books.author', DB::raw('SUM(raporty_empiku.ilosc_sztuk_s) as total_sales'))
                ->whereBetween('raporty_empiku.data', [$startDate, $endDate])
                ->groupBy('books.author')
                ->orderBy('total_sales', 'desc')
                ->limit(30)
                ->get();
        });

        $totalSales = $topAuthors->sum('total_sales');

        $topAuthors = $topAuthors->map(function ($author) use ($totalSales) {
            $author->sales_share = $totalSales > 0 ? round(($author->total_sales / $totalSales) * 100, 2) : 0;
            return $author;
        });

	  \Log::info("Date: " . $date->format('Y-m-d'));
        \Log::info("Previous Month: $previousMonth, Next Month: $nextMonth");

        return view('top-authors', compact('topAuthors', 'date', 'previousMonth', 'nextMonth', 'totalSales'));
    }


    // Metoda dla raportu dziennego
	public function daily($year = null, $month = null, $day = null)
	{
    // Ustawienie daty na dzień poprzedni, jeśli parametry nie są podane
    $date = $year && $month && $day ? Carbon::createFromDate($year, $month, $day) : Carbon::yesterday();
    $previousDay = $date->copy()->subDay();
    $nextDay = $date->copy()->addDay();

    $cacheKey = "top_authors_daily_{$date->format('Y_m_d')}";
    $cacheTime = 60 * 60 * 24; // 1 dzień

    $topAuthorsDaily = Cache::remember($cacheKey, $cacheTime, function () use ($date) {
        return DB::table('raporty_empiku')
            ->join('books', 'raporty_empiku.ean', '=', 'books.ean')
            ->select('books.author', DB::raw('SUM(raporty_empiku.ilosc_sztuk_s) as total_sales'))
            ->whereDate('raporty_empiku.data', $date)
            ->groupBy('books.author')
            ->orderBy('total_sales', 'desc')
            ->limit(30)
            ->get();
    });

    $totalSalesOfDay = $topAuthorsDaily->sum('total_sales');

    $topAuthorsDaily = $topAuthorsDaily->map(function ($author) use ($totalSalesOfDay) {
        $author->sales_share = $totalSalesOfDay > 0 ? round(($author->total_sales / $totalSalesOfDay) * 100, 2) : 0;
        return $author;
    });

        return view('top-authors-daily', compact('topAuthorsDaily', 'date', 'previousDay', 'nextDay'));

}

}

