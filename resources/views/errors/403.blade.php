@extends('layouts.client')

@section('title', 'Доступ запрещён')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center">
        <div class="text-9xl font-bold text-red-500 mb-6">403</div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Доступ запрещён</h1>
        <p class="text-xl text-gray-600 mb-10">У вас нет прав для просмотра этой страницы.</p>
        
        <div class="space-x-4">
            <a href="{{ route('client.dashboard') }}" 
               class="inline-block bg-blue-600 text-white px-8 py-4 rounded-3xl font-semibold">
                В личный кабинет
            </a>
            <a href="{{ route('home') }}" 
               class="inline-block border border-gray-300 px-8 py-4 rounded-3xl font-semibold hover:bg-gray-50">
                На главную
            </a>
        </div>
    </div>
</div>
@endsection