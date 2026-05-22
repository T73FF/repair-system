<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - РемонтСервис</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar { width: 260px; }
        .nav-link { transition: all 0.2s; }
        .nav-link:hover { background-color: #1f2937; }
        .nav-link-active { background-color: #374151; color: white; font-weight: 600; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <div class="bg-gray-900 text-white sidebar flex flex-col">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold tracking-tight">РемонтСервис</h1>
                <p class="text-gray-400 text-sm mt-1">Учёт ремонта техники</p>
            </div>

            <div class="flex-1 overflow-y-auto py-6 px-3">
<nav class="space-y-1">
    @if(auth()->check())
        @if(auth()->user()->hasRole('client'))
            <!-- Меню для клиента -->
            <a href="{{ route('client.dashboard') }}" 
               class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('client.dashboard') ? 'nav-link-active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Мои заявки</span>
            </a>
        @else
            <!-- Меню для сотрудников -->
            <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Дашборд</span>
            </a>

            <a href="{{ route('orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('orders.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-tools w-5"></i>
                <span>Заявки на ремонт</span>
            </a>

            <a href="{{ route('clients.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('clients.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Клиенты</span>
            </a>

            <a href="{{ route('equipment.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('equipment.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-laptop w-5"></i>
                <span>Техника</span>
            </a>

            <a href="{{ route('spare-parts.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('spare-parts.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-box w-5"></i>
                <span>Склад запчастей</span>
            </a>

            <a href="{{ route('reports.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('reports.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Отчёты</span>
            </a>
        @endif
    @endif
</nav>
            </div>
            <!-- User info -->
            <div class="p-4 border-t border-gray-800 mt-auto">
                @auth
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center text-lg">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->role ?? 'Пользователь' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-gray-800 rounded-xl text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Выйти</span>
                    </button>
                </form>
                @endauth
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @yield('content')
        </div>
    </div>
</body>
</html>