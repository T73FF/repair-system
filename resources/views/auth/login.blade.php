@extends('layouts.client')

@section('title', 'Вход')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-tools text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white">Добро пожаловать!</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Войдите в свой аккаунт</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                <input type="email" name="email" 
                       class="w-full px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white"
                       required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Пароль</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-900 text-slate-800 dark:text-white"
                       required>
            </div>

            <button type="submit"
                    class="w-full btn-gradient text-white font-semibold py-3 rounded-xl text-lg transition transform active:scale-95">
                Войти
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Нет аккаунта? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Зарегистрироваться
                </a>
            </p>
        </div>
    </div>
</div>
@endsection