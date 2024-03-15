{{-- resources/views/import.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Import CSV') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
		    <div class="alert alert-danger">
    		    {{ session('error') }}
		    </div>
		    @endif

                    {{-- Formularz importu CSV --}}
                    <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">Wybierz plik CSV do importu. Tylko w sytuacji kiedy import automatyczny sie nie powiódł.</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="report_date">Wybierz datę raportu. Pamiętaj, aby wybrać <strong>faktyczny dzień sprzedaży.</strong> (domyślnie data ustawiona jest na dzień wcześniej)</label>
                            <input type="date" class="form-control" style="width: 150px;" id="report_date" name="report_date" required>

<script>
    window.onload = function() {
        var date = new Date();
        date.setDate(date.getDate() - 1);

        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2); // Dodaje 0 na początku, jeśli jest potrzebne
        var day = ('0' + date.getDate()).slice(-2);

        var yesterday = year + '-' + month + '-' + day;

        document.getElementById('report_date').value = yesterday;
    };
</script>
							
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Importuj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
<div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
 <div class="card-header">Status importów plików</div>
<div class="month-navigation text-center my-3">
  <a href="{{ url('/import/' . $previousMonth->month . '/' . $previousMonth->year) }}">Poprzedni miesiąc</a> | 
<a href="{{ url('/import/' . $nextMonth->month . '/' . $nextMonth->year) }}">Następny miesiąc</a>

</div>

<table class="table">
    <thead>
        <tr>
            <th class="align-middle text-center">Dzień</th>
            <th class="align-middle text-center">Status danych</th>
            <th class="align-middle text-center">Kontrola ilości</th>
            <th class="align-middle text-center">Akcje</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($daysData as $dayData)
            <tr>
                <td class="align-middle text-center ">{{ $dayData['date']}}</td>

                <td class="align-middle text-center {{ $dayData['isDataAvailable'] ? 'data-available' : 'data-unavailable' }}">
                    {{ $dayData['isDataAvailable'] ? 'Dane dostępne' : 'Brak danych' }} </td>
                    
                <td class="align-middle text-center">{{ $dayData['sumIloscSztuk'] }}</td>
            
                <td class="align-middle text-center">
            
                    @if ($dayData['isDataAvailable'])
                        <form action="{{ route('delete_report', ['date' => $dayData['date']]) }}" method="POST">

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Usuń Raport</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>





</div>
</div>
</div>


@endsection
