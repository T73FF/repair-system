@extends('layouts.client')

@section('title', 'Новая заявка')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 md:py-12">
    <div class="text-center mb-6 md:mb-10">
        <h1 class="text-2xl md:text-4xl font-bold text-slate-800 dark:text-white">Подать заявку на ремонт</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm md:text-lg">Заполните форму — мы свяжемся с вами в течение 15 минут</p>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-5 md:p-8">
        <form method="POST" action="{{ route('public.request.store') }}">
            @csrf

@auth
{{-- Пользователь авторизован — данные подтягиваются автоматически --}}
<div class="bg-gray-100 dark:bg-blue-900/30 border border-gray-300 dark:border-blue-700 rounded-xl p-3 mb-6">
    <div class="flex gap-2">
        <i class="fas fa-user-circle text-gray-600 dark:text-blue-300 text-base mt-0.5"></i>
        <div class="flex-1">
            <p class="text-gray-800 dark:text-blue-100 text-sm font-semibold">
                Вы авторизованы как:
            </p>
            <p class="text-gray-800 dark:text-blue-100 text-sm font-semibold">
                {{ Auth::user()->name }}
            </p>
            <p class="text-gray-600 dark:text-blue-300 text-xs mt-0.5">
                📞 {{ Auth::user()->phone }}
            </p>
            <p class="text-gray-600 dark:text-blue-300 text-xs mt-1">
                ✅ Ваши контакты добавятся автоматически
            </p>
        </div>
    </div>
</div>

<input type="hidden" name="name" value="{{ Auth::user()->name }}">
<input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
@endauth

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Бренд техники <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" required placeholder="Lenovo, HP, Samsung..."
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Модель <span class="text-red-500">*</span></label>
                    <input type="text" name="model" required placeholder="IdeaPad 330, iPhone 15..."
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Опишите проблему <span class="text-red-500">*</span></label>
                <textarea name="problem_description" rows="4" required
                          class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white"
                          placeholder="Экран не включается, шумит вентилятор, не заряжается..."></textarea>
            </div>

            <button type="submit" 
                    class="mt-6 w-full btn-gradient text-white font-semibold py-3 rounded-xl text-base transition transform active:scale-95">
                @auth
                    📱 Отправить заявку
                @else
                    📝 Отправить заявку
                @endauth
            </button>
        </form>

        @guest
        <div class="mt-6 text-center">
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Уже есть аккаунт? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Войдите</a>
            </p>
        </div>
        @endguest
    </div>
</div>
@endsection