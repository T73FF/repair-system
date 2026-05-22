@extends('layouts.client')

@section('title', 'Проверка статуса заявки')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 md:py-16">
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold text-slate-800 dark:text-white">Проверить статус заявки</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-2 text-sm md:text-base">Введите номер вашей заявки</p>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-5 md:p-8 mb-8">
        <form method="GET" action="{{ route('public.check-status') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="order_number" value="{{ $orderNumber ?? '' }}" 
                       placeholder="R-2026-0001" 
                       class="w-full px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white">
            </div>
            <button type="submit" 
                    class="w-full md:w-auto bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold transition">
                Найти
            </button>
        </form>
    </div>

    @if(isset($order) && $order)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-5 md:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-4">
                <div>
                    <span class="font-mono text-xl md:text-2xl font-bold text-slate-800 dark:text-white">№{{ $order->order_number }}</span>
                </div>
                <span class="px-4 py-2 rounded-xl text-sm font-medium inline-block w-fit
                    @if($order->status == 'ready') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300
                    @elseif($order->status == 'in_progress') bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300
                    @elseif($order->status == 'new') bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300
                    @elseif($order->status == 'diagnostic') bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300
                    @elseif($order->status == 'waiting_parts') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300
                    @elseif($order->status == 'issued') bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300
                    @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif">
                    @switch($order->status)
                        @case('new') 📋 Новая @break
                        @case('diagnostic') 🔍 На диагностике @break
                        @case('in_progress') 🔧 В работе @break
                        @case('waiting_parts') ⏳ Ожидает запчасти @break
                        @case('ready') ✅ Готов к выдаче @break
                        @case('issued') 🎉 Выдан @break
                        @case('cancelled') ❌ Отменена @break
                        @default {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    @endswitch
                </span>
            </div>

            <div class="mt-6">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Техника:</p>
                <p class="text-lg md:text-xl font-semibold text-slate-800 dark:text-white mt-1">
                    {{ $order->equipment->brand ?? '' }} {{ $order->equipment->model ?? '' }}
                </p>
            </div>

            <div class="mt-6">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Проблема:</p>
                <p class="text-slate-700 dark:text-slate-300 mt-1 text-sm md:text-base">{{ $order->problem_description }}</p>
            </div>

            @if($order->total_amount > 0)
            <div class="mt-6 pt-4 border-t">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Сумма ремонта</p>
                <p class="text-2xl md:text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ number_format($order->total_amount, 2) }} ₽</p>
            </div>
            @endif
        </div>
    @elseif($orderNumber)
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-2xl p-8 text-center">
            <p class="text-red-600 dark:text-red-400">Заявка с номером <strong>{{ $orderNumber }}</strong> не найдена</p>
        </div>
    @endif
</div>
@endsection