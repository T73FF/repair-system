<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('repairOrders')
                    ->latest()
                    ->paginate(20);
        
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|unique:clients,phone',
            'email' => 'nullable|email|unique:clients,email',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
                         ->with('success', 'Клиент успешно добавлен!');
    }

    public function show(Client $client)
    {
        $client->load('repairOrders.equipment');
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|unique:clients,phone,' . $client->id,
            'email' => 'nullable|email|unique:clients,email,' . $client->id,
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')
                         ->with('success', 'Клиент обновлён!');
    }
}