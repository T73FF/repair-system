@extends('layouts.app')

@section('title', 'Отчёты и аналитика')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-8">Отчёты и аналитика</h1>

    <a href="{{ route('reports.exportPdf') }}" 
   class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl flex items-center gap-2">
    <i class="fas fa-file-pdf"></i> Скачать PDF
</a>

    <!-- Основные показатели -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-3xl shadow p-8">
        <p class="text-gray-500">Всего заявок</p>
        <p class="text-5xl font-bold mt-3">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white rounded-3xl shadow p-8">
        <p class="text-gray-500">Выручка</p>
        <p class="text-5xl font-bold text-green-600 mt-3">{{ number_format($totalRevenue, 2) }} ₽</p>
    </div>
    <div class="bg-white rounded-3xl shadow p-8">
        <p class="text-gray-500">Себестоимость</p>
        <p class="text-5xl font-bold text-orange-600 mt-3">{{ number_format($totalCost ?? 0, 2) }} ₽</p>
    </div>
    <div class="bg-white rounded-3xl shadow p-8">
        <p class="text-gray-500">Прибыль</p>
        <p class="text-5xl font-bold text-emerald-600 mt-3">{{ number_format($totalProfit ?? 0, 2) }} ₽</p>
    </div>
</div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Статусы заявок -->
        <div class="bg-white rounded-3xl shadow p-8">
            <h2 class="text-xl font-semibold mb-6">Заявки по статусам</h2>
            <div class="space-y-4">
                @foreach($statusStats as $stat)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $stat->status)) }}</span>
                    <span class="font-bold">{{ $stat->count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Топ запчастей -->
        <div class="bg-white rounded-3xl shadow p-8">
            <h2 class="text-xl font-semibold mb-6">Самые используемые запчасти</h2>
            @if($topParts->isNotEmpty())
                <div class="space-y-4">
                    @foreach($topParts as $part)
                    <div class="flex justify-between">
                        <span>{{ $part->name }} <span class="text-xs text-gray-500">({{ $part->article }})</span></span>
                        <span class="font-semibold">{{ $part->total_qty }} шт.</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400">Пока нет данных</p>
            @endif
        </div>

        <!-- Топ клиентов -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow p-8">
            <h2 class="text-xl font-semibold mb-6">Топ клиентов по сумме</h2>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left">Клиент</th>
                        <th class="px-6 py-4 text-left">Кол-во заявок</th>
                        <th class="px-6 py-4 text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($topClients as $client)
                    <tr>
                        <td class="px-6 py-4">{{ $client->name }}</td>
                        <td class="px-6 py-4">{{ $client->orders_count }}</td>
                        <td class="px-6 py-4 text-right font-semibold">{{ number_format($client->total_spent, 2) }} ₽</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection