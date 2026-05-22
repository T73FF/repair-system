@extends('layouts.app')

@section('title', 'Новый клиент')

@section('content')
<div class="p-8 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Новый клиент</h1>

    <form method="POST" action="{{ route('clients.store') }}" class="bg-white rounded-2xl shadow p-8">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ФИО клиента</label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Телефон <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Адрес</label>
                <input type="text" name="address" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Примечание</label>
                <textarea name="notes" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"></textarea>
            </div>
        </div>

        <div class="mt-10">
            <button type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-2xl text-lg">
                Создать клиента
            </button>
        </div>
    </form>
</div>
@endsection