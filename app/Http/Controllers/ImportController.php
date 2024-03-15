<?php

// app/Http/Controllers/ImportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RaportEmpiku;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RaportyEmpikuImport;
use App\Models\RaportDays;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class ImportController extends Controller
{
    // ...

    public function showImportForm()
    {
        return view('import'); // Zwraca widok import.blade.php
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'report_date' => 'required|date',
        ]);

        $date = $request->report_date;
        
          // Sprawdź, czy data już istnieje w bazie danych
	$existingReport = RaportDays::whereDate('data', $date)->first();

    if ($existingReport) {
        return back()->with('error', 'Raport z tą datą już istnieje.');
    }
        
        $import = new RaportyEmpikuImport($date);
        Excel::import($import, $request->file('csv_file'));

        return back()->with('success', 'Raport został pomyślnie zaimportowany.');
    }


public function showImport($month = null, $year = null)
{
    $currentMonth = $month ?? Carbon::now()->month;
    $currentYear = $year ?? Carbon::now()->year;
    $previousMonth = Carbon::create($currentYear, $currentMonth, 1)->subMonth();
    $nextMonth = Carbon::create($currentYear, $currentMonth, 1)->addMonth();
    $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
    $endOfMonth = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();

    // Pobieranie danych za cały miesiąc jednym zapytaniem
    $monthlyData = RaportDays::whereBetween('data', [$startOfMonth, $endOfMonth])
                             ->groupBy('data')
                             ->selectRaw('date(data) as date, sum(ilosc_sztuk_s) as sumIloscSztuk')
                             ->get()
                             ->keyBy('date'); // Indeksowanie według daty

    $daysData = collect();
    for ($day = 1; $day <= $endOfMonth->day; $day++) {
        $date = Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');

        $daysData->push([
            'date' => $date,
            'sumIloscSztuk' => $monthlyData->has($date) ? $monthlyData[$date]->sumIloscSztuk : 0,
            'isDataAvailable' => $monthlyData->has($date)
        ]);
    }

        return view('import', compact('daysData', 'previousMonth', 'nextMonth'));
}

 
 

public function deleteReport($date)
{
    Log::info('Data otrzymana w deleteReport: ' . $date);

    try {
        // Usuń wszystkie raporty odpowiadające podanej dacie
        $deletedCount = RaportDays::where('data', $date)->delete();

        //czy raporty zostały usunięte
        if ($deletedCount == 0) {
            return back()->with('error', 'Nie znaleziono raportów dla podanej daty.');
        }

        return back()->with('success', 'Wszystkie raporty dla podanej daty zostały pomyślnie usunięte.');
	
	} catch (\Exception $e) {
        // Zaloguj wyjątek
        Log::error('Błąd podczas usuwania raportów: ' . $e->getMessage());

        return back()->with('error', 'Wystąpił błąd podczas usuwania raportów.');
    }
}





}

