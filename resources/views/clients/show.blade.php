@extends('layouts.app')

@section('title', 'Клиент - {{ $client->name }}')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold">{{ $client->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $client->phone }} • {{ $client->email ?? 'Email не указан' }}</p>
            </div>
            <a href="{{ route('clients.edit', $client) }}" 
               class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl">
                Редактировать
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Информация о клиенте -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-6">Информация</h2>
                    <div class="space-y-5">
                        <div>
                            <p class="text-gray-500 text-sm">Телефон</p>
                            <p class="text-lg font-medium">{{ $client->phone }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Email</p>
                            <p class="text-lg">{{ $client->email ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Адрес</p>
                            <p>{{ $client->address ?? 'Не указан' }}</p>
                        </div>
                        @if($client->notes)
                        <div>
                            <p class="text-gray-500 text-sm">Примечание</p>
                            <p class="text-gray-700">{{ $client->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Заявки клиента -->
            <div class="lg:col-span-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Заявки клиента ({{ $client->repairOrders->count() }})</h2>
                    <a href="{{ route('orders.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm">
                        + Новая заявка
                    </a>
                </div>

                @if($client->repairOrders->isEmpty())
                    <div class="bg-white rounded-2xl shadow p-12 text-center">
                        <p class="text-gray-400">У клиента пока нет заявок</p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left">№ Заявки</th>
                                    <th class="px-6 py-4 text-left">Техника</th>
                                    <th class="px-6 py-4 text-left">Проблема</th>
                                    <th class="px-6 py-4 text-left">Статус</th>
                                    <th class="px-6 py-4 text-left">Сумма</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($client->repairOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('orders.show', $order) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->equipment->brand ?? '' }} {{ $order->equipment->model ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($order->problem_description, 50) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs 
                                            @if($order->status == 'ready') bg-green-100 text-green-700
                                            @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                                            @else bg-blue-100 text-blue-700 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold">{{ number_format($order->total_amount, 2) }} ₽</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection