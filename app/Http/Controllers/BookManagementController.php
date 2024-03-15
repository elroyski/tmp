<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Illuminate\Support\Facades\Log; 

class BookManagementController extends Controller
{
    public function refillBooks()
    {
        Log::info('Metoda refillBooks została wywołana.');

        // Truncate tabeli books
        Book::truncate();
    sleep(1);
        // Uruchomienie komend Artisan
         Artisan::call('elibri:refill-queue');
    sleep(1);
         Artisan::call('display:books-metadata');

        return redirect('/elibri')->with('success', 'Książki zostały zaktualizowane.');
    }
}
