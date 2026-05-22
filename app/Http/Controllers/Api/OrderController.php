<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        if (!$client) {
            return response()->json(['message' => 'Клиент не найден'], 404);
        }
        
        $orders = RepairOrder::where('client_id', $client->id)
            ->with('equipment')
            ->latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
    
    public function show(RepairOrder $order)
    {
        // Проверка, что заявка принадлежит авторизованному клиенту
        $user = auth()->user();
        if ($order->client_id !== $user->client?->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order->load(['client', 'equipment', 'items', 'spareParts.sparePart'])
        ]);
    }
}