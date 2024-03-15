<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportEmpiku extends Model
{
    protected $table = 'raporty_empiku';
    protected $fillable = [
	'data',
        'id_indeksu',
        'nr_katalogowy',
        'ean',
        'nazwa_indeksu',
        'store_id',
        'site_name',
        'status_indeksu',
        'ilosc_sztuk_s',
        'ilosc_sztuk_z',
        'producent',
    ];

}
