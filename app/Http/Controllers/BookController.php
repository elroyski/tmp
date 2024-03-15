<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller
{
    public function index($author = null)
    {
        $query = Book::orderBy('publishing_date', 'desc');

        if (!empty($author)) {
            $author = str_replace('_', ' ', $author);
            $query->where('author', $author);
        }

        $books = $query->get();
        $authors = Book::distinct()->pluck('author')->sort();

        // Dodanie pobierania dodatkowych informacji
        $bookCount = Book::count();
        $lastUpdate = Book::max('created_at');

        return view('elibri', [
            'books' => $books,
            'selectedAuthor' => $author,
            'authors' => $authors,
            'bookCount' => $bookCount,
            'lastUpdate' => $lastUpdate ? 
	    Carbon::parse($lastUpdate)->format('d-m-Y H:i:s') : 'Brak danych'
        ]);
    }
}
