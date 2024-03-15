{{-- resources/views/monthly-stats.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    {{ __('Statystyki miesięczne: ') . $date->format('Y-m') }}
                    <strong>Suma miesięcznie: {{ $monthlyTotal }}</strong>
                </div>
                <div class="card-body">
                <form action="{{ url('/monthly-stats') }}" method="get" id="month-year-form">
    <div class="form-group">
        <label for="month-year">Wybierz miesiąc i rok:</label>
        <input type="month" id="month-year" name="month-year" class="form-control mb-3" onchange="this.form.submit()" style="width:150px" >
    </div>
</form>
                
                    <div class="mb-3">
                        <a href="{{ url('/monthly-stats/' . $previousMonth) }}" class="btn btn-primary">&lt; Poprzedni Miesiąc</a>
                        <a href="{{ url('/monthly-stats/' . $nextMonth) }}" class="btn btn-primary">Następny Miesiąc &gt;</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>EAN</th>
                                <th>Nazwa Indeksu</th>
                                <th>Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stats as $stat)
                                <tr>
                                    <td>{{ $stat->ean }}</td>
                                    <td>{{ $stat->nazwa_indeksu }}</td>
                                    <td>{{ $stat->ilosc }}</td>
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
