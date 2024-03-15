<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $storeType;

    public function __construct($startDate, $endDate, $storeType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->storeType = $storeType;
    }

public function collection()
{
    $query = DB::table('raporty_empiku')
        ->select('ean', 'nazwa_indeksu', 'id_indeksu', DB::raw('SUM(ilosc_sztuk_s) as total_quantity'))
        ->whereBetween('data', [$this->startDate, $this->endDate]);

    if ($this->storeType == 'empik') {
        $query->where('store_id', 70401);
    } elseif ($this->storeType == 'salons') {
        $query->where('store_id', '!=', 70401);
    }

    $query->groupBy('ean', 'nazwa_indeksu', 'id_indeksu')
          ->orderBy('total_quantity', 'desc');
    return $query->get();
}


public function headings(): array
{
    return ['EAN', 'Nazwa Indeksu', 'ID Indeksu Gold', 'Suma ilości sztuk'];
}


}
