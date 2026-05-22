<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $activePromotions = Promotion::where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->get();

        return view('clients.promotions', compact('activePromotions'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:promotions,code',
            'repair_order_id' => 'required|exists:repair_orders,id',
        ]);

        $promotion = Promotion::where('code', $request->code)
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->first();

        if (!$promotion) {
            return response()->json(['error' => 'Промокод недействителен или истёк'], 422);
        }

        $order = RepairOrder::find($request->repair_order_id);
        
        // Проверяем, что заявка принадлежит клиенту
        if ($order->client_id !== auth()->user()->client->id) {
            return response()->json(['error' => 'Доступ запрещён'], 403);
        }

        // Сохраняем промокод в сессию или в заказ
        session(['applied_coupon' => [
            'code' => $promotion->code,
            'discount_percent' => $promotion->discount_percent,
            'discount_amount' => $promotion->discount_amount,
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Промокод применён! Скидка ' . ($promotion->discount_percent ? $promotion->discount_percent . '%' : $promotion->discount_amount . '₽'),
            'discount_percent' => $promotion->discount_percent,
            'discount_amount' => $promotion->discount_amount,
        ]);
    }
}