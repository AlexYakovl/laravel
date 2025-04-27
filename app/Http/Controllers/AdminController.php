<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Gate;


class AdminController extends Controller
{
    public function index()
    {

        if (!Gate::allows('admin')) {
            abort(403, 'Доступ запрещен');
        }


        $clients = Client::all();
        return view('admin.index', compact('clients'));

    }

}

