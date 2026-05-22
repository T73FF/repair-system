@extends('layouts.client')

@section('title', 'Заявка №' . $order->order_number)

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <!-- Кнопка назад -->
    <a href="{{ route('client.dashboard') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 transition">
        <i class="fas fa-arrow-left"></i>
        Назад к моим заявкам
    </a>

    <!-- Карточка заявки -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Шапка с номером и статусом -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-gray-400 text-sm uppercase tracking-wide">Номер заявки</p>
                <h1 class="text-3xl md:text-4xl font-bold text-white font-mono">{{ $order->order_number }}</h1>
                <p class="text-gray-400 text-sm mt-2">Создана: {{ $order->created_at->format('d.m.Y в H:i') }}</p>
            </div>
            <div>
                <span class="px-6 py-3 rounded-2xl text-lg font-semibold inline-block
                    @if($order->status == 'new') bg-blue-500 text-white
                    @elseif($order->status == 'diagnostic') bg-purple-500 text-white
                    @elseif($order->status == 'in_progress') bg-orange-500 text-white
                    @elseif($order->status == 'waiting_parts') bg-yellow-500 text-white
                    @elseif($order->status == 'ready') bg-green-500 text-white
                    @elseif($order->status == 'issued') bg-emerald-600 text-white
                    @elseif($order->status == 'cancelled') bg-red-500 text-white
                    @else bg-gray-500 text-white @endif">
                    @switch($order->status)
                        @case('new') 📋 Новая @break
                        @case('diagnostic') 🔍 На диагностике @break
                        @case('in_progress') 🔧 В работе @break
                        @case('waiting_parts') ⏳ Ожидает запчасти @break
                        @case('ready') ✅ Готов к выдаче @break
                        @case('issued') 🎉 Выдан клиенту @break
                        @case('cancelled') ❌ Отменена @break
                        @default {{ ucfirst($order->status) }}
                    @endswitch
                </span>
            </div>
        </div>

        <!-- Блок с техникой -->
        <div class="p-8 border-b">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-laptop text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Техника</p>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $order->equipment->brand ?? '' }} {{ $order->equipment->model ?? '' }}
                    </h2>
                </div>
            </div>
            @if($order->equipment->serial_number)
                <p class="text-gray-500 text-sm ml-16">Серийный номер: <span class="font-mono">{{ $order->equipment->serial_number }}</span></p>
            @endif
        </div>

        <!-- Описание проблемы -->
        <div class="p-8 border-b bg-gray-50">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-blue-500"></i>
                Описание проблемы
            </h3>
            <p class="text-gray-700 leading-relaxed">{{ $order->problem_description }}</p>
        </div>

        <!-- Работы и запчасти -->
        @if($order->items->isNotEmpty() || $order->spareParts->isNotEmpty())
        <div class="p-8 border-b">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-tools text-blue-500"></i>
                Выполненные работы и запчасти
            </h3>
            
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center py-2 border-b last:border-0">
                    <div>
                        <p class="font-medium">{{ $item->service_name }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->price, 2) }} ₽</p>
                    </div>
                    <p class="font-semibold text-green-600">{{ number_format($item->total, 2) }} ₽</p>
                </div>
                @endforeach
                
                @foreach($order->spareParts as $item)
                <div class="flex justify-between items-center py-2 border-b last:border-0">
                    <div>
                        <p class="font-medium">{{ $item->sparePart->name ?? 'Запчасть' }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->price_per_unit, 2) }} ₽</p>
                    </div>
                    <p class="font-semibold text-green-600">{{ number_format($item->total, 2) }} ₽</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Итоговая сумма -->
        <div class="p-8 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">Итого к оплате</p>
                    @if($order->paid_amount > 0)
                        <p class="text-sm text-gray-400">Оплачено: {{ number_format($order->paid_amount, 2) }} ₽</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-green-600">{{ number_format($order->total_amount, 2) }} ₽</p>
                    @if($order->total_amount > 0 && $order->paid_amount < $order->total_amount)
                        <p class="text-sm text-red-500">Остаток: {{ number_format($order->total_amount - $order->paid_amount, 2) }} ₽</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Статус-бар с визуализацией -->
        <div class="p-8 bg-gray-50 border-t">
            <h3 class="font-semibold text-gray-700 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-500"></i>
                Ход выполнения
            </h3>
            
            <div class="relative">
                <div class="flex justify-between mb-2 text-xs text-gray-500">
                    <span class="text-center w-1/5">Новая</span>
                    <span class="text-center w-1/5">Диагностика</span>
                    <span class="text-center w-1/5">В работе</span>
                    <span class="text-center w-1/5">Готово</span>
                    <span class="text-center w-1/5">Выдан</span>
                </div>
                <div class="flex h-3 rounded-full overflow-hidden">
                    @php
                        $steps = ['new', 'diagnostic', 'in_progress', 'ready', 'issued'];
                        $currentIndex = array_search($order->status, $steps);
                        if ($currentIndex === false) $currentIndex = -1;
                    @endphp
                    @foreach($steps as $index => $step)
                        <div class="h-full flex-1 {{ $index <= $currentIndex ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Комментарии (если есть история статусов) -->
        @if($order->statusHistory->isNotEmpty())
        <div class="p-8 border-t">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-blue-500"></i>
                История изменений
            </h3>
            <div class="space-y-3 max-h-60 overflow-y-auto">
                @foreach($order->statusHistory->take(5) as $history)
                <div class="flex gap-3 text-sm">
                    <div class="w-24 text-gray-400">{{ $history->created_at->format('d.m.Y') }}</div>
                    <div class="flex-1">
                        <span class="font-medium">
                            {{ ucfirst(str_replace('_', ' ', $history->old_status ?? 'Создана')) }}
                        </span>
                        <i class="fas fa-arrow-right mx-2 text-gray-400"></i>
                        <span class="font-medium">
                            {{ ucfirst(str_replace('_', ' ', $history->new_status)) }}
                        </span>
                        @if($history->comment)
                            <p class="text-gray-500 text-xs mt-1">{{ $history->comment }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Помощь / контакты -->
    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">
            <i class="fas fa-phone-alt mr-2"></i> 
            Остались вопросы? Позвоните нам: <a href="tel:+7XXXXXXXXXX" class="text-blue-600 hover:underline">+7 (XXX) XXX-XX-XX</a>
        </p>
    </div>
</div>
@endsection