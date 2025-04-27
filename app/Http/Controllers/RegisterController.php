<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $client = Client::create([
            'id' => $user->id,
            'full_name' => $user->name,
        ]);

        $accountNumber = Account::where('client_id', $client->id)->count() + 1;

        Account::create([
            'client_id' => $client->id,
            'number' => $accountNumber,
            'currency' => 'RUB',
            'balance' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('cabinet');
    }
}
