<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">
    <title>@yield('title', 'РемонтСервис')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#6366f1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="РемонтСервис">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
            padding-left: env(safe-area-inset-left);
            padding-right: env(safe-area-inset-right);
        }
        
        main {
            flex: 1;
        }
        
        /* Фикс для навигации под челкой */
        .safe-nav {
            padding-top: max(0.75rem, env(safe-area-inset-top));
        }
        
        /* Светлая тема (по умолчанию) */
        html.light body {
            background: #f5f3ff;
        }
        
        html.light .bg-white {
            background-color: #ffffff !important;
        }
        
        html.light .bg-slate-50,
        html.light .bg-gray-50,
        html.light .bg-\[\#f5f3ff\] {
            background-color: #f5f3ff !important;
        }
        
        html.light .text-slate-800,
        html.light .text-gray-800 {
            color: #1e293b !important;
        }
        
        html.light .text-slate-600,
        html.light .text-gray-600,
        html.light .text-slate-500,
        html.light .text-slate-400 {
            color: #475569 !important;
        }
        
        html.light .text-slate-700 {
            color: #334155 !important;
        }
        
        html.light .border-slate-200 {
            border-color: #e2e8f0 !important;
        }
        
        html.light .bg-gradient-to-br.from-indigo-50.to-purple-50 {
            background: linear-gradient(to bottom right, #eef2ff, #faf5ff) !important;
        }
        
        html.light nav {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        
        html.light nav .text-slate-600 {
            color: #475569 !important;
        }
        
        /* Тёмная тема */
        html.dark body {
            background: #0f0f1a;
        }
        
        html.dark .bg-white {
            background-color: #1a1a2e !important;
        }
        
        html.dark .bg-slate-50,
        html.dark .bg-gray-50,
        html.dark .bg-\[\#f5f3ff\] {
            background-color: #16162a !important;
        }
        
        html.dark .text-slate-800,
        html.dark .text-gray-800 {
            color: #e2e8f0 !important;
        }
        
        html.dark .text-slate-600,
        html.dark .text-gray-600,
        html.dark .text-slate-500,
        html.dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        
        html.dark .text-slate-700 {
            color: #cbd5e1 !important;
        }
        
        html.dark .border-slate-100,
        html.dark .border-slate-200,
        html.dark .border-purple-100 {
            border-color: #2d2d44 !important;
        }
        
        html.dark .shadow-md,
        html.dark .shadow-sm,
        html.dark .shadow-lg {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
        }
        
        html.dark .bg-gradient-to-r.from-slate-800 {
            background-image: linear-gradient(to right, #1e1e2e, #2d2d44) !important;
        }
        
        html.dark .bg-gradient-to-br.from-indigo-50.to-purple-50 {
            background: #1a1a2e !important;
        }
        
        html.dark .from-indigo-50 {
            --tw-gradient-from: #1a1a2e !important;
        }
        
        html.dark .to-purple-50 {
            --tw-gradient-to: #2d2d44 !important;
        }
        
        html.dark .bg-indigo-100 {
            background-color: #2d2d44 !important;
        }
        
        html.dark .bg-emerald-100 {
            background-color: #1a3a2a !important;
        }
        
        html.dark .bg-amber-100 {
            background-color: #3a2a1a !important;
        }
        
        html.dark .bg-indigo-50,
        html.dark .bg-purple-50 {
            background-color: #1a1a2e !important;
        }
        
        html.dark .text-indigo-600 {
            color: #a78bfa !important;
        }
        
        html.dark nav {
            background-color: rgba(30, 30, 46, 0.95) !important;
        }
        
        html.dark nav .text-slate-600 {
            color: #94a3b8 !important;
        }
        
        /* Градиенты и общие стили */
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:active {
            transform: scale(0.98);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transition: all 0.2s ease;
        }
        
        .btn-gradient:active {
            transform: scale(0.97);
        }
        
        /* Скроллбар */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #e9d5ff;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 10px;
        }
        
        html.dark ::-webkit-scrollbar-track {
            background: #2d2d44;
        }
        
        .theme-transition {
            transition: all 0.3s ease;
        }
        
        /* Дополнительные классы */
        .bg-light-section {
            background-color: #f5f3ff;
        }
        
        html.dark .bg-light-section {
            background-color: #0f0f1a;
        }
        
        .bg-dark-section {
            background-color: #ffffff;
        }
        
        html.dark .bg-dark-section {
            background-color: #0f0f1a;
        }
        
        html.dark .border-slate-200 {
            border-color: #334155 !important;
        }
        
        html.dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Футер в светлой теме (твои настройки) */
        html.light footer {
            background: linear-gradient(to right, #0f172a, #1e293b) !important;
        }
        html.light footer .text-slate-500,
        html.light footer .text-slate-600,
        html.light footer .text-slate-400 {
            color: #e2e8f0 !important;
        }
        html.light footer .text-slate-800 {
            color: #ffffff !important;
        }
        html.light footer .bg-slate-200 {
            background-color: #334155 !important;
        }
        html.light footer .text-slate-700 {
            color: #ffffff !important;
        }
        html.light footer .border-slate-200 {
            border-color: #334155 !important;
        }
        html.light footer a {
            color: #cbd5e1 !important;
        }
        html.light footer a:hover {
            color: #a78bfa !important;
        }
        
        /* Мобильная навигация */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background: white;
            z-index: 1000;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding-top: env(safe-area-inset-top);
        }
        
        html.dark .mobile-menu {
            background: #1a1a2e;
        }
        
        .mobile-menu.open {
            left: 0;
        }
        
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        
        .menu-overlay.open {
            display: block;
        }
        
        /* Адаптивные карточки */
        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 0.5rem;
            }
            
            .stat-card {
                padding: 0.5rem !important;
            }
            
            .stat-number {
                font-size: 1rem !important;
            }
            
            .stat-label {
                font-size: 0.6rem !important;
            }
            
            .order-card {
                padding: 1rem !important;
            }
            
            .order-number {
                font-size: 0.9rem !important;
            }
            
            .order-amount {
                font-size: 1.25rem !important;
            }
        }
        
        /* Улучшение таргетинга для мобильных кнопок */
        @media (max-width: 768px) {
            button, a {
                min-height: 44px;
            }
            
            .nav-link {
                padding: 0.75rem 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Мобильное меню -->
    <div class="menu-overlay" id="menuOverlay"></div>
    <div class="mobile-menu" id="mobileMenu">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700 safe-nav">
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-slate-800 dark:text-white">Меню</span>
                <button id="closeMenuBtn" class="text-slate-500 dark:text-slate-400 w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="p-4 space-y-4">
            <a href="{{ route('home') }}" class="nav-link flex items-center gap-3 py-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <i class="fas fa-home w-5"></i> Главная
            </a>
            <a href="{{ route('public.request.create') }}" class="nav-link flex items-center gap-3 py-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <i class="fas fa-plus-circle w-5"></i> Новая заявка
            </a>
            <a href="{{ route('public.check-status') }}" class="nav-link flex items-center gap-3 py-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <i class="fas fa-search w-5"></i> Проверить статус
            </a>
            <a href="{{ route('client.dashboard') }}" class="nav-link flex items-center gap-3 py-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <i class="fas fa-list w-5"></i> Мои заявки
            </a>
        </div>
    </div>

    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm shadow-sm sticky top-0 z-50 border-b border-slate-200 dark:border-slate-700 safe-nav">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Меню бургер (только на мобилках) -->
            <button id="menuToggle" class="md:hidden text-slate-700 dark:text-slate-300 text-xl w-10 h-10 flex items-center justify-center">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="w-10 md:hidden"></div>
            
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-tools text-white text-lg md:text-xl"></i>
                </div>
                <span class="text-lg md:text-2xl font-bold text-slate-800 dark:text-white">
                    РемонтСервис
                </span>
            </a>
            
            <div class="hidden md:flex items-center gap-6 text-slate-600 dark:text-slate-300">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Главная</a>
                <a href="{{ route('public.request.create') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Новая заявка</a>
                <a href="{{ route('public.check-status') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Проверить статус</a>
                <a href="{{ route('client.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition font-semibold">Мои заявки</a>
            </div>

            <div class="flex items-center gap-2">
                <!-- Кнопка переключения темы -->
                <button id="theme-toggle" class="w-9 h-9 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center hover:scale-110 transition shadow-sm border border-slate-200 dark:border-slate-600">
                    <i id="theme-icon" class="fas fa-moon text-slate-700 dark:text-yellow-400 text-sm"></i>
                </button>

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-3 py-1.5 rounded-xl hover:shadow-md transition min-h-[44px]">
                            <div class="w-7 h-7 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-slate-700 dark:text-slate-200 text-sm hidden sm:inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-purple-100 dark:border-slate-700">
                            <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-purple-50 dark:hover:bg-slate-700 rounded-t-xl text-slate-700 dark:text-slate-300">
                                <i class="fas fa-list text-indigo-500"></i> Мои заявки
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 hover:bg-purple-50 dark:hover:bg-slate-700 rounded-b-xl w-full text-left text-slate-700 dark:text-slate-300">
                                    <i class="fas fa-sign-out-alt text-red-400"></i> Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-gradient text-white px-4 py-2 rounded-xl font-medium text-sm shadow-md min-h-[44px] flex items-center">
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

    <footer class="bg-gradient-to-r from-slate-900 to-slate-800 text-slate-400 mt-8">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="text-center md:text-left">
                    <div class="flex items-center gap-2 mb-3 justify-center md:justify-start">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-white">РемонтСервис</span>
                    </div>
                    <p class="text-xs">Качественный ремонт техники с 2015 года</p>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-semibold text-white mb-2 text-sm">Контакты</h4>
                    <p class="text-xs"><i class="fas fa-phone-alt mr-1 text-indigo-400 text-xs"></i> +7 (800) 123-45-67</p>
                    <p class="text-xs mt-1"><i class="fas fa-envelope mr-1 text-indigo-400 text-xs"></i> info@repair-service.ru</p>
                    <p class="text-xs mt-1"><i class="fas fa-map-marker-alt mr-1 text-indigo-400 text-xs"></i> г. Пермь</p>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-semibold text-white mb-2 text-sm">Часы работы</h4>
                    <p class="text-xs">Пн-Пт: 10:00 – 20:00</p>
                    <p class="text-xs">Сб: 11:00 – 18:00</p>
                    <p class="text-xs">Вс: выходной</p>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="font-semibold text-white mb-2 text-sm">Мы в соцсетях</h4>
                    <div class="flex gap-3 justify-center md:justify-start">
                        <a href="#" class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-vk text-xs"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-telegram text-xs"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-whatsapp text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-700 pt-4 text-center text-xs">
                <p>&copy; {{ date('Y') }} РемонтСервис. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>

<script>
    // Тёмная тема
    (function() {
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        
        let isDark = localStorage.getItem('theme') === 'dark';
        
        if (isDark) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
            if (themeIcon) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
            if (themeIcon) {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                    localStorage.setItem('theme', 'light');
                    if (themeIcon) {
                        themeIcon.classList.remove('fa-sun');
                        themeIcon.classList.add('fa-moon');
                    }
                } else {
                    document.documentElement.classList.remove('light');
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    if (themeIcon) {
                        themeIcon.classList.remove('fa-moon');
                        themeIcon.classList.add('fa-sun');
                    }
                }
            });
        }
    })();
    
    // Мобильное меню
    (function() {
        const menuToggle = document.getElementById('menuToggle');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOverlay = document.getElementById('menuOverlay');
        
        function openMenu() {
            mobileMenu.classList.add('open');
            menuOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMenu() {
            mobileMenu.classList.remove('open');
            menuOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }
        
        if (menuToggle) menuToggle.addEventListener('click', openMenu);
        if (closeMenuBtn) closeMenuBtn.addEventListener('click', closeMenu);
        if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);
    })();
</script>

<!-- Регистрация Service Worker -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('Service Worker зарегистрирован:', registration);
            }).catch(function(error) {
                console.log('Ошибка регистрации Service Worker:', error);
            });
        });
    }
</script>

@stack('scripts')
</html>