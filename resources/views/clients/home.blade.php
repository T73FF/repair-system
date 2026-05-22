@extends('layouts.client')

@section('title', 'РемонтСервис — Ремонт любой техники')

@section('content')
<!-- HERO -->
<section class="relative min-h-[600px] flex items-center overflow-hidden gradient-bg">
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-24 text-center">
        <div class="inline-block glass rounded-full px-6 py-2 mb-6">
            <span class="text-white text-sm">Профессиональный ремонт с гарантией</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
            Ремонт техники<br>
            <span class="text-indigo-200">за 1–3 дня</span>
        </h1>
        <p class="text-xl md:text-2xl mb-12 max-w-2xl mx-auto text-white/90">
            Ноутбуки • Компьютеры • Смартфоны • Принтеры • Бытовая техника
        </p>
        <div class="flex flex-col sm:flex-row gap-5 justify-center">
            <a href="{{ route('public.request.create') }}" 
               class="group bg-white text-indigo-600 hover:bg-slate-50 font-semibold px-10 py-5 rounded-2xl transition-all transform hover:scale-105 shadow-xl flex items-center gap-3 justify-center">
                <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                Оставить заявку
            </a>
            <a href="{{ route('public.check-status') }}" 
               class="group glass hover:bg-white/20 text-white font-semibold px-10 py-5 rounded-2xl transition-all border border-white/30 flex items-center gap-3 justify-center">
                <i class="fas fa-search group-hover:scale-110 transition-transform"></i>
                Проверить статус
            </a>
        </div>
    </div>

    <!-- Акции и скидки -->
@if(isset($activePromotions) && $activePromotions->count() > 0)
    <div class="max-w-7xl mx-auto px-6 -mt-8 relative z-20">
        @foreach($activePromotions as $promotion)
            <x-promotion-timer :promotion="$promotion" />
        @endforeach
    </div>
@endif
    
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full">
            <path fill="currentColor" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" class="text-white"></path>
        </svg>
    </div>
</section>

<!-- Преимущества -->
<section class="py-20 bg-[#f5f3ff] dark:bg-[#0f0f1a]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-500 font-semibold text-sm uppercase tracking-wider">Преимущества</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2 text-slate-800 dark:text-white">
                Почему выбирают нас?
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 text-center card-hover shadow-md">
                <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-5">
                    ⚡
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Быстро</h3>
                <p class="text-slate-500 dark:text-slate-300">Диагностика за 1 час,<br>большинство ремонтов — от 1 дня</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 text-center card-hover shadow-md">
                <div class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/50 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-5">
                    🛡️
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Гарантия</h3>
                <p class="text-slate-500 dark:text-slate-300">До 12 месяцев на работы<br>и оригинальные запчасти</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 text-center card-hover shadow-md">
                <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/50 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-5">
                    🤝
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Честно</h3>
                <p class="text-slate-500 dark:text-slate-300">Фиксированная цена после диагностики,<br>без скрытых платежей</p>
            </div>
        </div>
    </div>
</section>

<!-- Как работаем -->
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-500 font-semibold text-sm uppercase tracking-wider">Процесс</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2 text-slate-800 dark:text-white">
                Как мы работаем
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-md">1</div>
                <h3 class="font-semibold text-xl text-slate-800 dark:text-white mb-1">Оставляете заявку</h3>
                <p class="text-slate-500 dark:text-slate-300 text-sm">Онлайн за 30 секунд<br>или по телефону</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-md">2</div>
                <h3 class="font-semibold text-xl text-slate-800 dark:text-white mb-1">Привозите технику</h3>
                <p class="text-slate-500 dark:text-slate-300 text-sm">В наш сервисный центр<br>или вызываете курьера</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-md">3</div>
                <h3 class="font-semibold text-xl text-slate-800 dark:text-white mb-1">Бесплатная диагностика</h3>
                <p class="text-slate-500 dark:text-slate-300 text-sm">Точная причина поломки<br>и цена ремонта</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-md">4</div>
                <h3 class="font-semibold text-xl text-slate-800 dark:text-white mb-1">Забираете готовым</h3>
                <p class="text-slate-500 dark:text-slate-300 text-sm">Работаем быстро<br>и с гарантией</p>
            </div>
        </div>
    </div>
</section>

<!-- Что ремонтируем -->
<section class="py-20 bg-[#f5f3ff] dark:bg-[#0f0f1a]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-500 font-semibold text-sm uppercase tracking-wider">Направления</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2 text-slate-800 dark:text-white">
                Ремонтируем всё
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-laptop text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Ноутбуки</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-desktop text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Компьютеры</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-mobile-alt text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Смартфоны</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-print text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Принтеры</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-tv text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Телевизоры</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-utensils text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Бытовая техника</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-car text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Автоэлектроника</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 text-center card-hover shadow-sm cursor-pointer">
                <i class="fas fa-microchip text-4xl text-indigo-500 mb-3"></i>
                <p class="font-semibold text-slate-700 dark:text-white">Другое</p>
            </div>
        </div>
    </div>
</section>

<!-- Отзывы -->
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-500 font-semibold text-sm uppercase tracking-wider">Отзывы</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2 text-slate-800 dark:text-white">
                Что говорят клиенты
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:bg-slate-800 rounded-2xl p-6 shadow-md card-hover">
                <div class="flex text-amber-400 mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-300 italic">"Быстро починили ноутбук. Диагностика бесплатно, цену сказали сразу. Рекомендую!"</p>
                <p class="font-semibold mt-4 text-indigo-600 dark:text-indigo-400">— Анна К.</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:bg-slate-800 rounded-2xl p-6 shadow-md card-hover">
                <div class="flex text-amber-400 mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-300 italic">"Ремонтировали iPhone. Забрали из дома, привезли готовый через 2 дня. Гарантию дали 6 месяцев."</p>
                <p class="font-semibold mt-4 text-indigo-600 dark:text-indigo-400">— Дмитрий П.</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:bg-slate-800 rounded-2xl p-6 shadow-md card-hover">
                <div class="flex text-amber-400 mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-300 italic">"Вежливые мастера, всё объяснили. Цена не изменилась после диагностики. Буду обращаться ещё."</p>
                <p class="font-semibold mt-4 text-indigo-600 dark:text-indigo-400">— Елена В.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 gradient-bg text-white relative overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
        <h2 class="text-3xl md:text-5xl font-bold mb-5">Готовы починить вашу технику?</h2>
        <p class="text-xl mb-8 opacity-90">Оставьте заявку сейчас — мы перезвоним за 15 минут</p>
        <a href="{{ route('public.request.create') }}" 
           class="inline-block bg-white text-indigo-600 hover:bg-slate-100 text-xl font-semibold px-12 py-5 rounded-2xl transition-all transform hover:scale-105 shadow-lg">
            📝 Оставить заявку →
        </a>
    </div>
</section>
@endsection