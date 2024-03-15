{{-- resources/views/annual-stats.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">Statystyki miesięczne, rocznie narastająco</div>
                <div class="card-body">
                    <table class="table">
					
                        <thead>
                            <tr>
                                <th>Rok</th>
                                <th>Miesiąc</th>
                                <th>Ilość</th>
                                <th>Ilość rocznie narastająco</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stats as $stat)
                                <tr>
                                    <td>{{ $stat->rok }}</td>
                                    <td>{{ $stat->miesiac }}</td>
                                    <td>{{ $stat->ilosc }}</td>
                                    <td>{{ $stat->ilosc_narastajaco }}</td>
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