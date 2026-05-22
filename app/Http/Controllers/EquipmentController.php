<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Client;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('client')->latest()->paginate(15);
        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('equipment.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'brand' => 'required|string',
            'model' => 'required|string',
            'serial_number' => 'nullable|string|unique:equipment,serial_number',
            'category' => 'required|string',
            'manufacture_year' => 'nullable|integer',
            'condition' => 'required|in:new,used,after_repair',
            'notes' => 'nullable|string',
        ]);

        Equipment::create($request->all());

        return redirect()->route('equipment.index')
                         ->with('success', 'Техника успешно добавлена!');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['client', 'repairOrders']);
        return view('equipment.show', compact('equipment'));
    }
}