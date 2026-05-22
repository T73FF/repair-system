<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index()
    {
        $spareParts = SparePart::latest()->paginate(20);
        return view('spare-parts.index', compact('spareParts'));
    }

    public function create()
    {
        return view('spare-parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'article' => 'required|string|unique:spare_parts,article',
            'name' => 'required|string',
            'brand' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        SparePart::create($request->all());

        return redirect()->route('spare-parts.index')
                         ->with('success', 'Запчасть успешно добавлена на склад!');
    }

    public function edit(SparePart $sparePart)
    {
        return view('spare-parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'article' => 'required|string|unique:spare_parts,article,' . $sparePart->id,
            'name' => 'required|string',
            'brand' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string',
        ]);

        $sparePart->update($request->all());

        return redirect()->route('spare-parts.index')
                         ->with('success', 'Запчасть обновлена!');
    }
}