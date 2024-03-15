@extends('layouts.app')
@section('content')

   

    <form method="GET" action="{{ route('inventory.index') }}">
 <div class="card">
                <div class="card-header">Zapas magazynowy</div>
                <div class="card-body">     

	 <div class="form-group">
            <label for="store_id">Salon:</label>
            <select name="store_id" id="store_id" class="form-control mb-3" onchange="this.form.submit()" style="width:400px">  
                <option value="">Wybierz salon</option>
                @foreach ($stores as $store)
                    <option value="{{ $store->store_id }}" {{ $selectedStore == $store->store_id ? 'selected' : '' }}>{{ $store->site_name }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>EAN</th>
                <th>Nazwa</th>
                <th>Ilość zapasu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->ean }}</td>
                    <td>{{ $stock->nazwa_indeksu }}</td>
                    <td>{{ $stock->total_stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
