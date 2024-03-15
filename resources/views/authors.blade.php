{{-- resources/views/authors.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Zarządzanie autorami') }}</div>
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

                    <h6>Tworzy relację autor-email. Po uzupełnieniu danych Autor zacznie otrzymywać raport Empik dla swoich tytułów. Ustawienie TAK/NIE decyduje o dołączeniu do raportów wewnętrznych</h6><br />

{{-- Sekcja dodawania nowego autora --}}
<div class="mb-4">
    <h5>Dodaj Nowego Autora</h5>
    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Pierwsza kolumna - Wybór autora --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author-name">Wybierz Autora z listy (autor musi być w bazie Elibri!)</label>
                    <select class="form-control" name="name" id="author-name">
                        @foreach ($bookAuthors as $bookAuthor)
                            <option value="{{ $bookAuthor }}">{{ $bookAuthor }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Druga kolumna - Email i opcje raportów --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author-email">Email</label>
                    <input type="email" class="form-control" id="author-email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <label for="include-in-reports">Dołącz do Raportów</label>
                    <select class="form-control" name="include_in_reports" id="include-in-reports">
                        <option value="0">Nie</option>
                        <option value="1">Tak</option>
                    </select>
                </div>
				
                <button type="submit" class="btn btn-primary mt-3">Dodaj autora</button>
            </div>
        </div>
    </form>
</div>

{{-- Istniejąca tabela autorów --}}
<div class="container">
    {{-- Tabela autorów --}}
</div>



                    <div class="container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Imię autora</th>
                                    <th>Email</th>
                                    <th>Do raportów</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($authors as $author)
                                    <tr>
                                        <td>{{ $author->name }}</td>
                                        <td>{{ $author->email ?? 'Brak' }}</td>
                                        <td>
                                            <form action="{{ route('authors.updateIncludeInReports', $author->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="include_in_reports" onchange="this.form.submit()">
                                                    <option value="1" {{ $author->include_in_reports ? 'selected' : '' }}>Tak</option>
                                                    <option value="0" {{ !$author->include_in_reports ? 'selected' : '' }}>Nie</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <form action="{{ route('authors.update', $author->id) }}" method="POST" class="flex-grow-1 mr-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="author" value="{{ $author->name }}">
                                                    <input type="email" name="email" class="form-control" placeholder="Adres e-mail">
                                                    <button type="submit" class="btn btn-info btn-sm mt-2">Aktualizuj e-mail</button>
                                                </form>
                                                
                                                <form action="{{ route('authors.destroy', $author->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">Usuń autora</button>
            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
