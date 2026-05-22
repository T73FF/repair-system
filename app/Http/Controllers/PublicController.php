<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Главная страница
    public function home()
    {
        $activePromotions = Promotion::where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->get();
        
        return view('clients.home', compact('activePromotions'));
    }

    // Публичная форма подачи заявки
    public function createRequest()
    {
        return view('public.request');
    }

    public function storeRequest(Request $request)
    {
        // Валидация
        if (auth()->check()) {
            // Для авторизованного пользователя — телефон и имя из сессии
            $validated = $request->validate([
                'brand' => 'required|string',
                'model' => 'required|string',
                'problem_description' => 'required|string',
            ]);
            
            $user = auth()->user();
            $name = $user->name;
            $phone = $user->phone;
            
            // Проверяем, что у пользователя есть телефон
            if (!$phone) {
                return back()->withErrors(['phone' => 'В вашем профиле не указан телефон. Пожалуйста, укажите его в личном кабинете.']);
            }
        } else {
            // Для гостя — проверяем все поля
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'brand' => 'required|string',
                'model' => 'required|string',
                'problem_description' => 'required|string',
            ]);
            
            $name = $request->name;
            $phone = $request->phone;
        }

        // Ищем или создаём пользователя по телефону
        $user = \App\Models\User::where('phone', $phone)->first();
        
        // Ищем или создаём клиента
        $client = null;
        
        if ($user) {
            // Пользователь существует — привязываем клиента
            $client = \App\Models\Client::where('user_id', $user->id)->first();
            
            if (!$client) {
                $client = \App\Models\Client::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'phone' => $phone,
                ]);
            } else {
                // Обновляем имя, если изменилось
                $client->update(['name' => $name]);
            }
        } else {
            // Гость — создаём клиента без user_id
            $client = \App\Models\Client::where('phone', $phone)->first();
            
            if (!$client) {
                $client = \App\Models\Client::create([
                    'user_id' => null,
                    'name' => $name,
                    'phone' => $phone,
                ]);
            }
        }

        // Создаём технику
        $equipment = \App\Models\Equipment::create([
            'client_id' => $client->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'category' => 'Другое',
            'condition' => 'used',
        ]);

        // Генерируем номер заявки
        $lastOrder = \App\Models\RepairOrder::latest('id')->first();
        $nextId = ($lastOrder ? $lastOrder->id + 1 : 1);
        $orderNumber = 'R-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        
        // Генерируем номер чека
        $invoiceNumber = 'ЧК-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        // Создаём заявку
        $order = \App\Models\RepairOrder::create([
            'order_number' => $orderNumber,
            'invoice_number' => $invoiceNumber,
            'client_id' => $client->id,
            'equipment_id' => $equipment->id,
            'problem_description' => $request->problem_description,
            'repair_type' => 'paid',
            'status' => 'new',
            'total_amount' => 0,
            'created_by' => auth()->check() ? auth()->id() : null,
        ]);

        // Если пользователь авторизован, но клиент ещё не привязан
        if (auth()->check() && !$client->user_id) {
            $client->update(['user_id' => auth()->id()]);
        }

        // Если пользователь НЕ авторизован, но клиент уже существует — предлагаем войти
        $message = "Заявка №<strong>{$orderNumber}</strong> успешно создана!";
        
        if (!auth()->check() && $user) {
            $message .= ' <a href="' . route('login') . '" class="underline">Войдите</a>, чтобы отслеживать статус в личном кабинете.';
        }

        return redirect()->route('public.check-status', ['order_number' => $orderNumber])
                         ->with('success', $message);
    }

    // Страница проверки статуса
    public function checkStatus(Request $request)
    {
        $order = null;
        $orderNumber = $request->get('order_number');

        if ($orderNumber) {
            $order = RepairOrder::where('order_number', $orderNumber)
                        ->with(['equipment', 'client'])
                        ->first();
        }

        return view('public.check-status', compact('order', 'orderNumber'));
    }
}