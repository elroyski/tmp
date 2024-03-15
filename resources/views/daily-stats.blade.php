{{-- resources/views/daily-stats.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                
	    <div class="card-header">
	        {{ __('Statystki dzienne: ') . $date->format('Y-m-d') . ' - ' }}<strong>{{ 'Suma: ' . $dailyTotal }}</strong>
	    </div>
                
                <div class="card-body">
                <div class="md-3">
                 <form action="{{ url('/daily-stats') }}" method="get" class="mb-3">
                        <div class="form-group">
                            <label for="date-picker">Wybierz datę:</label>
                            <input type="date" id="date-picker" name="date" class="form-control" style="width:150px" value="{{ $date->format('Y-m-d') }}" onchange="this.form.submit()">
                        </div>
                    </form>

                </div>
                
                    <a href="{{ url('/daily-stats/' . $previousDay) }}" class="btn btn-primary">&lt; Dzień Poprzedni</a>
                    <a href="{{ url('/daily-stats/' . $nextDay) }}" class="btn btn-primary">Dzień Następny &gt;</a>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>EAN</th>
                                <th>Tytuł</th>
                                <th>Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stats as $stat)
                                <tr>
                                    <td>{{ $stat->ean }}</td>
                                    <td>{{ $stat->nazwa_indeksu }}</td>
                                    <td>{{ $stat->ilość }}</td>
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
