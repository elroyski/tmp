<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\InventoryReportMail;
use Illuminate\Support\Facades\Log;



class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $selectedStore = $request->input('store_id', null);

        $stocks = DB::table('raporty_empiku')
				  ->whereDate('data', Carbon::now()->subDays(1))
                  ->when($selectedStore, function ($query) use ($selectedStore) {
                      return $query->where('store_id', $selectedStore);
                  })
                  ->select('ean', 'nazwa_indeksu', DB::raw('SUM(ilosc_sztuk_z) as total_stock'))
                  ->groupBy('ean', 'nazwa_indeksu')
                  ->orderBy('total_stock', 'desc')
                  ->get();

        $stores = DB::table('raporty_empiku')
                   ->select('store_id', 'site_name')
                   ->distinct()
                   ->get();

        return view('inventory', compact('stocks', 'stores', 'selectedStore'));
    }
	
	
	public function emailReport()
{
    $date = Carbon::now()->subDays(1)->format('Y-m-d');

    // Pobieranie danych ogólnych
    $stocks = DB::table('raporty_empiku')
                ->whereDate('data', $date)
                ->select('ean', 'nazwa_indeksu', DB::raw('SUM(ilosc_sztuk_z) as total_stock'))
                ->groupBy('ean', 'nazwa_indeksu')
                ->get()
				->sortByDesc('total_stock'); 

    // Pobieranie danych tylko dla Empik.com
    $empikStocks = DB::table('raporty_empiku')
                     ->whereDate('data', $date)
                     ->where('store_id', 0)
                     ->select('ean', DB::raw('SUM(ilosc_sztuk_z) as empik_stock'))
                     ->groupBy('ean')
                     ->get()->keyBy('ean');

    // Przygotowanie danych do raportu
    $reportData = $stocks->map(function($item) use ($empikStocks) {
        $ean = $item->ean;
        $empikStock = isset($empikStocks[$ean]) ? $empikStocks[$ean]->empik_stock : 0;
        $salonyStock = $item->total_stock - $empikStock;

        return (object)[
            'ean' => $item->ean,
            'nazwa_indeksu' => $item->nazwa_indeksu,
            'total_stock' => $item->total_stock,
            'empik_stock' => $empikStock,
            'salony_stock' => $salonyStock
        ];
    });
	
	 $kierownicyEmails = User::where('group', 'Kierownik')->pluck('email')->toArray();

	 foreach ($kierownicyEmails as $email) {
        Mail::to($email)->send(new InventoryReportMail($reportData));
    }

    Log::info('Raport magazynowy Empik.com wysłany do kierowników.');
}	
	
		
	
}
