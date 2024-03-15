{{-- resources/views/elibri.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Lista książek / import Elibri') }}</div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

		<div class="card-body">
		
		
		<a href="{{ url('/elibri/refill') }}" class="btn btn-danger mb-4">Ręcznie resetuj bazę i pobierz książki z  Elibri (nie zalecane!)</a>

		{{-- Informacje o liczbie książek i ostatniej aktualizacji --}}
<div>
    <p>Liczba tytułów w bazie: {{ $bookCount }}</p>
    <p>Ostatnia aktualizacja z Elibri: {{ $lastUpdate }}</p>
</div>
		
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ url('/elibri') }}" method="GET">
                                <div class="form-group">

<select name="author" class="form-control" onchange="authorChanged(this)">
<option value="">Wszyscy autorzy</option>
    @foreach ($authors as $authorOption)
        <option value="{{ $authorOption }}" {{ $selectedAuthor == $authorOption ? 'selected' : '' }}>{{ $authorOption }}</option>
    @endforeach
</select>




                                </div>
                            </form>
                        </div>
                    </div>


<script>
    function authorChanged(select) {
        var author = select.value;
        author = author.replace(/ /g, '_'); // Zamienia spacje na podkreślenia
        window.location.href = '{{ url('/elibri') }}' + '/' + author;
    }
</script>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tytuł</th>
                                <th>EAN</th>
                                <th>Cena</th>
                                <th>Autor</th>
                                <th>Data Wydania</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->ean }}</td>
                                    <td>{{ $book->price }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publishing_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

