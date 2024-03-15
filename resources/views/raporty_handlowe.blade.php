{{-- resources/views/raporty_handlowe.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Raporty Handlowe') }}</div>
                <div class="card-body">

		@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }} <a href="{{ route('download_report') }}" >Pobierz Raport</a>

		    </div>
		@endif


                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Formularz generowania raportu --}}
                    <form action="{{ route('generate_report') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="startDate">Data Od:</label>
                            <input type="date" style="width: 150px;" class="form-control" id="startDate" name="startDate" required >
                        </div>
                        <div class="form-group mt-2">
                            <label for="endDate">Data Do:</label>
                            <input type="date" style="width: 150px;" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="reportType">Typ Raportu:</label>
                            <select class="form-control" id="reportType" name="reportType">
                                <option value="all">Wszystko</option>
                                <option value="empik">Empik.com (store id=70401)</option>
                                <option value="salons">Salony Sprzedaży</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Generuj Raport</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
