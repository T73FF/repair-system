@extends('layouts.client')

@section('title', 'Нет соединения')

@section('content')
<div class="max-w-md mx-auto px-6 py-20 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-wifi text-4xl text-gray-400"></i>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-3">Нет интернета</h1>
    <p class="text-gray-500 mb-8">
        Проверьте подключение к интернету и попробуйте снова
    </p>
    <button onclick="location.reload()" 
            class="bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition">
        Обновить
    </button>
</div>
@endsection