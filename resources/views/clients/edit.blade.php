@extends('layouts.app')

@section('title', 'Редактировать клиента')

@section('content')
<div class="p-8 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Редактировать клиента</h1>

    <form method="POST" action="{{ route('clients.update', $client) }}" class="bg-white rounded-2xl shadow p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ФИО клиента</label>
                <input type="text" name="name" value="{{ $client->name }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
                <input type="tel" name="phone" value="{{ $client->phone }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ $client->email }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Адрес</label>
                <input type="text" name="address" value="{{ $client->address }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Примечание</label>
                <textarea name="notes" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl">{{ $client->notes }}</textarea>
            </div>
        </div>

        <div class="mt-10 flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl">
                Сохранить изменения
            </button>
            <a href="{{ route('clients.index') }}" 
               class="flex-1 text-center border border-gray-300 hover:bg-gray-50 py-4 rounded-2xl font-medium">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection