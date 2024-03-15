<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesChartController; // Zaimportuj SalesChartController

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chartController = new SalesChartController();
        $salesData = $chartController->getSalesData(); // pobrania danych sprzedaży

        return view('home', compact('salesData'));
    }
}
