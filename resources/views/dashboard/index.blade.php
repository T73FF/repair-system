@extends('layouts.app')

@section('title', 'Дашборд')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Добро пожаловать, {{ Auth::user()->name }}!</h1>

        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">Всего заявок</h3>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">Новые</h3>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $stats['new_orders'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">В работе</h3>
                <p class="text-4xl font-bold text-orange-600 mt-2">{{ $stats['in_progress'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500 text-sm">Готовы</h3>
                <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['ready'] }}</p>
            </div>
        </div>

        <!-- Последние заявки -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">Последние заявки</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left">№</th>
                            <th class="px-6 py-4 text-left">Клиент</th>
                            <th class="px-6 py-4 text-left">Техника</th>
                            <th class="px-6 py-4 text-left">Статус</th>
                            <th class="px-6 py-4 text-left">Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_orders as $order)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">{{ $order->client->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $order->equipment->brand }} {{ $order->equipment->model }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    @if($order->status == 'new') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                                    @elseif($order->status == 'ready') bg-green-100 text-green-700 @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ number_format($order->total_amount, 2) }} ₽</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection