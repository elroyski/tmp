<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;  
use App\Exports\SalesReportExport;     
use Carbon\Carbon;

class RaportyHandloweController extends Controller
{
    
    /**
     * Wyświetla stronę główną raportów handlowych.
     */
    public function index()
    {
        return view('raporty_handlowe');
    }

    /**
     * Obsługuje żądanie generowania raportu.
     */

    public function generateReport(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');
    $storeType = $request->input('reportType'); // 'all', 'empik', 'salons'
    // Zapisz parametry raportu w sesji (lub w bazie danych)
    session(['report_params' => ['startDate' => $startDate, 'endDate' => $endDate, 'storeType' => $storeType]]);

    // Ustawienie informacji o sukcesie w sesji
    session()->flash('success', 'Raport jest gotowy do pobrania.');

    // Przekierowanie z powrotem do formularza
    return redirect()->route('raporty_handlowe');
}




public function downloadReport()
{
    


    $params = session('report_params');
    if (!$params) {
        return redirect()->route('raporty_handlowe')->with('error', 'Brak danych do generowania raportu.');
    }


    $startDate = Carbon::createFromFormat('Y-m-d', $params['startDate'])->format('Y_m_d');
    $endDate = Carbon::createFromFormat('Y-m-d', $params['endDate'])->format('Y_m_d');
    $storeType = $params['storeType'];

    $filename = "sales_report_{$storeType}_{$startDate}_to_{$endDate}.xlsx";

    return Excel::download(new SalesReportExport($startDate, $endDate, $storeType), $filename);


}


}    
    

