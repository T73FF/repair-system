@extends('layouts.app')

@section('title', 'Заявка №{{ $order->order_number }}')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold">Заявка №{{ $order->order_number }}</h1>
                <p class="text-gray-500">от {{ $order->created_at->format('d.m.Y в H:i') }}</p>
            </div>
            <span class="px-6 py-3 rounded-2xl text-lg font-semibold
                @if($order->status == 'new') bg-blue-100 text-blue-700
                @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                @elseif($order->status == 'ready') bg-green-100 text-green-700
                @elseif($order->status == 'issued') bg-emerald-100 text-emerald-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Левая колонка -->
            <div class="lg:col-span-7 space-y-8">

                <!-- Клиент и Техника -->
                <div class="bg-white rounded-3xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-6">Клиент и оборудование</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-gray-500">Клиент</p>
                            <p class="text-2xl font-medium">{{ $order->client->name ?? '—' }}</p>
                            <p class="text-gray-600">{{ $order->client->phone ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Техника</p>
                            <p class="text-2xl font-medium">{{ $order->equipment->brand ?? '' }} {{ $order->equipment->model ?? '' }}</p>
                            <p class="text-sm text-gray-600">С/Н: {{ $order->equipment->serial_number ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Описание проблемы -->
                <div class="bg-white rounded-3xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-4">Описание проблемы</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $order->problem_description }}</p>
                </div>

                <!-- Выполненные работы -->
                <div class="bg-white rounded-3xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-6">Выполненные работы</h2>
                    
                    @if($order->items->isNotEmpty())
                        <div class="space-y-4 mb-8">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center py-3 border-b last:border-0">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $item->service_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} шт. × {{ number_format($item->price, 2) }} ₽</p>
                                </div>
                                <p class="font-bold text-lg">{{ number_format($item->total, 2) }} ₽</p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 italic py-6">Работ пока не добавлено</p>
                    @endif

                    <form method="POST" action="{{ route('orders.addItem', $order) }}" class="border-t pt-6">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <input type="text" name="service_name" placeholder="Название работы" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                            </div>
                            <div class="col-span-5 md:col-span-2">
                                <input type="number" name="price" step="0.01" placeholder="Цена" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                            </div>
                            <div class="col-span-3 md:col-span-2">
                                <input type="number" name="quantity" value="1" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                            </div>
                            <div class="col-span-4 md:col-span-2">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-medium">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="lg:col-span-5 space-y-8">

                <div class="bg-white rounded-3xl shadow p-8 text-center">
                    <p class="text-gray-500">Общая сумма</p>
                    <p class="text-5xl font-bold text-green-600 mt-2">{{ number_format($order->total_amount ?? 0, 2) }} ₽</p>
                </div>

                <!-- Смена статуса -->
                <div class="bg-white rounded-3xl shadow p-8">
                    <h3 class="font-semibold mb-4">Смена статуса</h3>
                    <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-2xl mb-4">
                            <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новый</option>
                            <option value="diagnostic">На диагностике</option>
                            <option value="in_progress">В работе</option>
                            <option value="waiting_parts">Ожидает запчасти</option>
                            <option value="ready">Готов к выдаче</option>
                            <option value="issued">Выдан клиенту</option>
                            <option value="cancelled">Отменён</option>
                        </select>
                        <textarea name="comment" rows="2" placeholder="Комментарий..." class="w-full px-4 py-3 border border-gray-300 rounded-2xl"></textarea>
                        <button type="submit" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 rounded-2xl font-medium">
                            Обновить статус
                        </button>
                    </form>
                </div>

                <!-- Запчасти -->
                <div class="bg-white rounded-3xl shadow p-8">
                    <h3 class="font-semibold mb-4">Использованные запчасти</h3>
                    
                    @if($order->spareParts->isNotEmpty())
                        <div class="space-y-3 mb-6">
                            @foreach($order->spareParts as $item)
                            <div class="flex justify-between items-center py-2">
                                <div>
                                    <p class="font-medium">{{ $item->sparePart->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->sparePart->article ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <p>{{ $item->quantity }} × {{ number_format($item->price_per_unit, 2) }} ₽</p>
                                    <p class="font-semibold">{{ number_format($item->total, 2) }} ₽</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 italic mb-6">Запчастей не использовалось</p>
                    @endif

                    <form method="POST" action="{{ route('orders.addSparePart', $order) }}">
                        @csrf
                        <select name="spare_part_id" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl mb-3">
                            <option value="">Выберите запчасть со склада...</option>
                            @foreach(\App\Models\SparePart::where('stock_quantity', '>', 0)->get() as $part)
                                <option value="{{ $part->id }}">
                                    {{ $part->name }} ({{ $part->article }}) — {{ number_format($part->sale_price, 2) }} ₽
                                </option>
                            @endforeach
                        </select>
                        <div class="flex gap-3">
                            <input type="number" name="quantity" value="1" min="1" class="w-24 px-4 py-3 border border-gray-300 rounded-2xl">
                            <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-2xl font-medium">
                                Добавить запчасть
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection