@extends('layouts.client')

@section('title', 'Мои заявки')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                Мои заявки
            </h1>
            <p class="text-slate-500 mt-1">Отслеживайте статус ремонта в реальном времени</p>
        </div>
        <a href="{{ route('public.request.create') }}" 
           class="btn-gradient text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
            <i class="fas fa-plus"></i> Новая заявка
        </a>
    </div>

    <!-- Блок уведомлений -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    📱 Уведомления
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Включите уведомления, чтобы получать оповещения о смене статуса заявки
                </p>
            </div>
            <button id="enable-notifications-btn" 
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2.5 rounded-xl transition font-medium">
                🔔 Включить уведомления
            </button>
        </div>
    </div>

    <!-- Статистика по статусам -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
        <a href="{{ route('client.dashboard', ['status' => 'all']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'all' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-indigo-600">{{ $statusCounts['all'] }}</p>
            <p class="text-xs text-slate-500">Все</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'new']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'new' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-blue-500">{{ $statusCounts['new'] }}</p>
            <p class="text-xs text-slate-500">Новые</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'diagnostic']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'diagnostic' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-purple-500">{{ $statusCounts['diagnostic'] }}</p>
            <p class="text-xs text-slate-500">Диагностика</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'in_progress']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'in_progress' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-orange-500">{{ $statusCounts['in_progress'] }}</p>
            <p class="text-xs text-slate-500">В работе</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'waiting_parts']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'waiting_parts' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-yellow-500">{{ $statusCounts['waiting_parts'] }}</p>
            <p class="text-xs text-slate-500">Ждут запчасти</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'ready']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'ready' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-green-500">{{ $statusCounts['ready'] }}</p>
            <p class="text-xs text-slate-500">Готовы</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'issued']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'issued' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-emerald-500">{{ $statusCounts['issued'] }}</p>
            <p class="text-xs text-slate-500">Выданы</p>
        </a>
        <a href="{{ route('client.dashboard', ['status' => 'cancelled']) }}" 
           class="bg-white rounded-xl p-3 text-center hover:shadow-md transition-all {{ $currentStatus == 'cancelled' ? 'ring-2 ring-indigo-500 shadow-md' : '' }}">
            <p class="text-2xl font-bold text-red-500">{{ $statusCounts['cancelled'] }}</p>
            <p class="text-xs text-slate-500">Отменены</p>
        </a>
    </div>

    <!-- Поиск -->
    <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
        <form method="GET" action="{{ route('client.dashboard') }}" class="flex gap-3">
            @if(request()->has('status') && request()->status != 'all')
                <input type="hidden" name="status" value="{{ request()->status }}">
            @endif
            <div class="flex-1">
                <input type="text" name="search" value="{{ request()->search }}" 
                       placeholder="Поиск по номеру заявки, бренду или модели..."
                       class="w-full px-5 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl transition">
                <i class="fas fa-search"></i>
            </button>
            @if(request()->has('search'))
                <a href="{{ route('client.dashboard', request()->has('status') ? ['status' => request()->status] : []) }}" 
                   class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl transition">
                    Сбросить
                </a>
            @endif
        </form>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl shadow-md p-16 text-center">
            <i class="fas fa-box-open text-6xl text-slate-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-slate-400">У вас пока нет заявок</h3>
            <a href="{{ route('public.request.create') }}" class="mt-4 inline-block btn-gradient text-white px-8 py-3 rounded-xl">
                Создать первую заявку
            </a>
        </div>
    @else
        <div class="space-y-5">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 flex-wrap mb-3">
                                <span class="font-mono text-lg font-bold text-slate-800">#{{ $order->order_number }}</span>
                                <span class="px-3 py-1.5 text-sm rounded-xl font-medium 
                                    @if($order->status == 'ready') bg-green-100 text-green-700
                                    @elseif($order->status == 'in_progress') bg-orange-100 text-orange-700
                                    @elseif($order->status == 'new') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'diagnostic') bg-purple-100 text-purple-700
                                    @elseif($order->status == 'waiting_parts') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'issued') bg-emerald-100 text-emerald-700
                                    @else bg-red-100 text-red-700 @endif">
                                    @switch($order->status)
                                        @case('new') 📋 Новая @break
                                        @case('diagnostic') 🔍 На диагностике @break
                                        @case('in_progress') 🔧 В работе @break
                                        @case('waiting_parts') ⏳ Ожидает запчасти @break
                                        @case('ready') ✅ Готов к выдаче @break
                                        @case('issued') 🎉 Выдан @break
                                        @case('cancelled') ❌ Отменена @break
                                        @default {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </div>
                            <p class="text-xl font-semibold text-slate-800">
                                {{ $order->equipment->brand ?? '' }} {{ $order->equipment->model ?? '' }}
                            </p>
                            <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ Str::limit($order->problem_description, 80) }}</p>
                        </div>

                        <div class="text-left md:text-right">
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($order->total_amount, 2) }} ₽</p>
                            <p class="text-sm text-slate-400 mt-1">{{ $order->created_at->format('d.m.Y') }}</p>
                            <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                <a href="{{ route('client.order.show', $order) }}" 
                                   class="inline-flex items-center justify-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2.5 rounded-xl transition text-sm font-medium">
                                    Подробнее
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                                <a href="{{ route('client.order.invoice', $order) }}" 
                                   class="inline-flex items-center justify-center gap-2 bg-white dark:bg-white text-slate-700 dark:text-slate-800 hover:bg-slate-100 px-5 py-2.5 rounded-xl transition text-sm font-medium border border-slate-200 dark:border-slate-600">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    Скачать чек
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function() {
    const vapidKeyMeta = document.querySelector('meta[name="vapid-public-key"]');
    const vapidPublicKey = vapidKeyMeta ? vapidKeyMeta.getAttribute('content') : null;
    const btn = document.getElementById('enable-notifications-btn');
    
    if (!btn) return;
    
    if (!vapidPublicKey || vapidPublicKey === '') {
        console.error('VAPID публичный ключ отсутствует!');
        btn.disabled = true;
        btn.textContent = '❌ Ошибка: ключ не загружен';
        return;
    }
    
    // Проверяем, есть ли уже активная подписка
    async function checkExistingSubscription() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            return false;
        }
        
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();
        
        if (subscription) {
            // Подписка уже есть — меняем кнопку
            btn.textContent = '✅ Уведомления включены';
            btn.disabled = true;
            return true;
        }
        return false;
    }
    
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
    
    async function subscribeToPush() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            alert('Ваш браузер не поддерживает push-уведомления');
            return false;
        }
        
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            alert('Разрешение на уведомления не получено');
            return false;
        }
        
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });
        
        console.log('Подписка создана:', subscription);
        
        const response = await fetch('/push-subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(subscription)
        });
        
        if (response.ok) {
            btn.textContent = '✅ Уведомления включены';
            btn.disabled = true;
            alert('Уведомления успешно включены!');
            return true;
        } else {
            const error = await response.json();
            alert('Ошибка: ' + (error.error || 'Неизвестная ошибка'));
            return false;
        }
    }
    
    // При загрузке страницы проверяем существующую подписку
    checkExistingSubscription();
    
    // Вешаем обработчик на кнопку только если подписки ещё нет
    if (btn.textContent !== '✅ Уведомления включены') {
        btn.addEventListener('click', subscribeToPush);
    }
})();
</script>
@endpush