{{-- resources/views/raporty_handlowe.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Zarzadzanie użytkownikami') }}</div>
                <div class="card-body">

		@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }} 
		    </div>
		@endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
<h6>Dodaj pracownika Wydawnictwa. <b>Pracownik</b> otrzyma tylko top 20 z danego dnia, <b>Kierownik</b> otrzyma wszystkie raporty rozszeżone, <b>Kierownik+Autor</b> dodatkowo raporty Autorów.</b></h6>
<div class="container">

    <table class="table">
        <thead>
            <tr>
                <th>Imię</th>
                <th>Email</th>
                <th>Grupa</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('users.update_group', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="group" class="form-control">
                                <option value="Pracownik" {{ $user->group == 'Pracownik' ? 'selected' : '' }}>Pracownik</option>
                                <option value="Kierownik" {{ $user->group == 'Kierownik' ? 'selected' : '' }}>Kierownik</option>
                                <option value="Kierownik+Autorzy" {{ $user->group == 'Kierownik+Autorzy' ? 'selected' : '' }}>Kierownik+Autorzy</option>

                            </select>
                            <button type="submit" class="btn btn-info btn-sm mt-2">Zmień grupę</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Usuń użytkownika</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<div class="mt-4 mb-4">
    <h5>Dodaj nowego użytkownika</h5>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Imię:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control"  id="email" name="email" required>
        </div>
	<div class="form-group">
    <label for="password">Hasło:</label>
    <div class="input-group">
    <input type="input" class="form-control" id="password" name="password" required>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="generatePassword">Generuj</button>
        </div>
    </div>
</div>
<script>
document.getElementById('generatePassword').addEventListener('click', function() {
        var password = generateRandomPassword();
        document.getElementById('password').value = password;
    });

    function generateRandomPassword() {
        var length = 8; // Możesz zmienić długość hasła
        var charset = "!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        var retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }
</script>




        <div class="form-group">
            <label for="group">Grupa:</label>
            <select name="group" id="group" class="form-control">
                <option value="Pracownik">Pracownik</option>
                <option value="Kierownik">Kierownik</option>
                <option value="Kierownik+Autorzy">Kierownik+Autorzy</option>

                {{-- Dodaj więcej grup, jeśli potrzebujesz --}}
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Dodaj użytkownika</button>
    </form>
</div>		    

                
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
