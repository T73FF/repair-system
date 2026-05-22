@extends('layouts.app')

@section('title', 'Заявки на ремонт')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Заявки на ремонт</h1>
        <a href="{{ route('orders.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl flex items-center gap-2 font-medium">
            <i class="fas fa-plus"></i> Новая заявка
        </a>
    </div>

    <!-- Поиск и фильтры -->
    <div class="bg-white rounded-3xl shadow p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Поиск по №, клиенту, технике..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                    <option value="">Все статусы</option>
                    <option value="new" {{ request('status')=='new'?'selected':'' }}>Новый</option>
                    <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>В работе</option>
                    <option value="ready" {{ request('status')=='ready'?'selected':'' }}>Готов</option>
                    <option value="issued" {{ request('status')=='issued'?'selected':'' }}>Выдан</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-2xl hover:bg-gray-900">
                    Применить фильтры
                </button>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="w-full block text-center border border-gray-300 py-3 rounded-2xl hover:bg-gray-50">
                    Сбросить
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">№ Заявки</th>
                    <th class="px-6 py-4 text-left">Клиент</th>
                    <th class="px-6 py-4 text-left">Техника</th>
                    <th class="px-6 py-4 text-left">Проблема</th>
                    <th class="px-6 py-4 text-left">Статус</th>
                    <th class="px-6 py-4 text-left">Сумма</th>
                    <th class="px-6 py-4 text-left">Дата</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        <a href="{{ route('orders.show', $order) }}" class="hover:underline">{{ $order->order_number }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $order->client->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $order->equipment->brand }} {{ $order->equipment->model }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 max-w-md truncate">{{ Str::limit($order->problem_description, 70) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-1.5 rounded-full text-xs font-medium
                            @if($order->status == 'new') bg-blue-100 text-blue-700
                            @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                            @elseif($order->status == 'ready') bg-green-100 text-green-700
                            @elseif($order->status == 'issued') bg-emerald-100 text-emerald-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold">{{ number_format($order->total_amount, 2) }} ₽</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d.m.Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-16 text-gray-500">Заявок не найдено</td></tr>
                @endempty
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection