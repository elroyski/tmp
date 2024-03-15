<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{

   public function index()
{
    $authors = Author::all();
    $bookAuthors = Book::distinct()->pluck('author'); // Pobierz unikalnych autorów z tabeli books

    return view('authors', compact('authors', 'bookAuthors'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'nullable|email',
        'include_in_reports' => 'required|boolean'
    ]);

    Author::updateOrCreate(
        ['name' => $validatedData['name']], // Klucz do wyszukania
        [
            'email' => $validatedData['email'], 
            'include_in_reports' => $validatedData['include_in_reports']
        ]
    );

    return back()->with('success', 'Autor został zapisany.');
}

    public function updateIncludeInReports(Request $request, $authorId)
    {
        $author = Author::findOrFail($authorId);
        $includeInReports = $request->input('include_in_reports') === '1' ? 1 : 0;
        $author->update(['include_in_reports' => $includeInReports]);

        return back()->with('success', 'Status uwzględnienia w raportach został zaktualizowany.');
    }

    public function removeEmail(Request $request)
    {
        $authorName = $request->input('author');
        $author = Author::where('name', $authorName)->first();

        if ($author) {
            $author->update(['email' => null]);
        }

        return back()->with('success', 'Adres e-mail został usunięty.');
    }
	
	   public function update(Request $request, $authorId)
    {
        $validatedData = $request->validate([
              'email' => 'email' // Usunięto 'required'
        ]);

        $author = Author::findOrFail($authorId);
        $author->email = $validatedData['email'];
        $author->save();

        return back()->with('success', 'E-mail autora został zaktualizowany.');
    }

	public function destroy(Author $author)
	{
    $author->delete();
    return redirect()->route('authors.index')->with('success', 'Autor został usunięty.');
	}
}
