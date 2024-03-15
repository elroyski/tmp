{{-- resources/views/top-authors.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">Top Autorzy miesięcznie {{ $date->format('Y-m') }}</div>
                <div class="card-body">
                    <div class="mb-3">
		    <a href="{{ url('/top-authors/' . $previousMonth) }}" class="btn btn-primary">&lt; Poprzedni Miesiąc</a>
		    <a href="{{ url('/top-authors/' . $nextMonth) }}" class="btn btn-primary">Następny Miesiąc &gt;</a>


                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Autor</th>
                                <th>Ilość sprzedanych książek</th>
                                <th>Udział procentowy w sprzedaży</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topAuthors as $author)
                                <tr>
                                    <td>{{ $author->author }}</td>
                                    <td>{{ $author->total_sales }}</td>
                                    <td>{{ $author->sales_share }}%</td>
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
