<?php

// app/Imports/RaportyEmpikuImport.php

namespace App\Imports;

use App\Models\RaportEmpiku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
//use Maatwebsite\Excel\Concerns\WithProgressBar;

class RaportyEmpikuImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    protected $reportDate;

    public function __construct($reportDate)
    {
        $this->reportDate = $reportDate;
    }

    public function model(array $row)
    {
        
        return new RaportEmpiku([
            'data'           => $this->reportDate,
            'id_indeksu'     => $row['id_indeksu'],
            'nr_katalogowy'  => $row['nr_kat'],
            'ean'            => $row['ean'],
            'nazwa_indeksu'  => $row['nazwa_indeksu'],
            'store_id'       => $row['a_store_id'],
            'site_name'      => $row['site_name'],
            'status_indeksu' => $row['status_indeksu'],
            'ilosc_sztuk_s'  => $row['ilosc_sztuk_s'] !== null ? $row['ilosc_sztuk_s'] : 0,
            'ilosc_sztuk_z'  => $row['ilosc_sztuk_z'] !== null ? $row['ilosc_sztuk_z'] : 0,
            'producent'      => $row['producent'],
        ]);
    }


    public function headingRow(): int
    {
        return 1; // ominiecie naglowka
    }
	
	

    public function rules(): array
    {
        
        return [];
    }
}
