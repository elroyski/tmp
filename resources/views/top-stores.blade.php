{{-- resources/views/top-stores.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
	      <div class="card-header">
                    Najlepsze Punkty Sprzedaży w Roku <strong>{{ $year }}</strong> <br>
                    Empik.com: <strong>{{ $empikTotal }}</strong> | Salony: <strong>{{ $otherStoresTotal }} </strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ url('/top-stores/' . $previousYear) }}" class="btn btn-primary">&lt; Poprzedni Rok</a>
                        <a href="{{ url('/top-stores/' . $nextYear) }}" class="btn btn-primary">Następny Rok &gt;</a>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Store ID</th>
                                <th>Nazwa Sklepu</th>
                                <th>Ilość sprzedana</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topStores as $store)
                                <tr>
                                    <td>{{ $store->store_id }}</td>
                                    <td>{{ $store->site_name }}</td>
                                    <td>{{ $store->ilosc }}</td>
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
