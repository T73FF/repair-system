@extends('layouts.app')

@section('title', 'Техника - {{ $equipment->brand }} {{ $equipment->model }}')

@section('content')
<div class="p-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold">{{ $equipment->brand }} {{ $equipment->model }}</h1>
                <p class="text-gray-500">Серийный номер: <span class="font-medium">{{ $equipment->serial_number ?? '—' }}</span></p>
            </div>
            <a href="{{ route('equipment.index') }}" class="text-gray-500 hover:text-gray-700">
                ← Назад к списку
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Основная информация -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-6">Информация об оборудовании</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-500 text-sm">Клиент</p>
                            <p class="text-lg font-medium">{{ $equipment->client->name }}</p>
                            <p class="text-sm">{{ $equipment->client->phone }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Категория</p>
                            <p class="text-lg font-medium">{{ $equipment->category }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Год выпуска</p>
                            <p class="text-lg">{{ $equipment->manufacture_year ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Состояние</p>
                            <span class="px-4 py-2 rounded-2xl text-sm font-medium
                                @if($equipment->condition == 'new') bg-green-100 text-green-700
                                @elseif($equipment->condition == 'after_repair') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $equipment->condition == 'new' ? 'Новое' : ($equipment->condition == 'used' ? 'Б/У' : 'После ремонта') }}
                            </span>
                        </div>
                    </div>

                    @if($equipment->notes)
                    <div class="mt-8">
                        <p class="text-gray-500 text-sm">Примечание</p>
                        <p class="text-gray-700 mt-2">{{ $equipment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- История ремонтов -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-6">История ремонтов</h2>
                    
                    @if($equipment->repairOrders->isEmpty())
                        <p class="text-gray-400 italic py-8 text-center">Ремонтов по этой технике ещё не было</p>
                    @else
                        <div class="space-y-4">
                            @foreach($equipment->repairOrders as $order)
                            <div class="border rounded-xl p-5 hover:shadow transition">
                                <div class="flex justify-between">
                                    <a href="{{ route('orders.show', $order) }}" class="font-medium text-blue-600 hover:underline">
                                        №{{ $order->order_number }}
                                    </a>
                                    <span class="text-sm px-3 py-1 rounded-full
                                        @if($order->status == 'ready') bg-green-100 text-green-700
                                        @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($order->problem_description, 80) }}</p>
                                <p class="text-xs text-gray-500 mt-3">{{ $order->created_at->format('d.m.Y') }} • {{ number_format($order->total_amount, 2) }} ₽</p>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection