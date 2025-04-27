<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class CabinetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $client = Client::where('id', $user->id)->with('accounts')->first();
        $nextAccountNumber = $client ? ($client->accounts()->count() + 1) : 1;

        return view('cabinet.index', compact('client', 'nextAccountNumber'));
    }

}


