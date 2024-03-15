<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


public function index()
{
    $users = User::all();
    return view('users', compact('users'));
}

public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('users.index')->with('success', 'Użytkownik został usunięty.');
}

public function updateGroup(Request $request, User $user)
{
    $user->update(['group' => $request->group]);
    return back()->with('success', 'Grupa użytkownika została zmieniona.');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'group' => 'required'
    ]);

    $validatedData['password'] = Hash::make($validatedData['password']);
    User::create($validatedData);
    return redirect()->route('users.index')->with('success', 'Nowy użytkownik został dodany.');
}




}

