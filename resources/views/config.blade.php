@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    Konfiguracja
                </div>
                <div class="card-body">
<div class="container">
    <h5>Cache</h5>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('clear.cache') }}" class="btn btn-danger">Usuń pamięć podręczną</a>
    <a href="{{ route('regenerate.cache') }}" class="btn btn-primary">Wygeneruj ponownie pamięć podręczną</a>
</div>
@endsection
