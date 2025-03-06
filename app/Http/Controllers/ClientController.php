<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::with('accounts')->findOrFail($id);
        return view('clients.show', compact('client'));
    }
}

