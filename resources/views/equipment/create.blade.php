@extends('layouts.app')

@section('title', 'Добавить технику')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Добавить новую технику</h1>

    <form method="POST" action="{{ route('equipment.store') }}" class="bg-white rounded-2xl shadow p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Клиент <span class="text-red-500">*</span></label>
                <select name="client_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                    <option value="">Выберите клиента...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} — {{ $client->phone }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Бренд <span class="text-red-500">*</span></label>
                <input type="text" name="brand" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Модель <span class="text-red-500">*</span></label>
                <input type="text" name="model" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Серийный номер</label>
                <input type="text" name="serial_number" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Категория <span class="text-red-500">*</span></label>
                <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                    <option value="">Выберите категорию...</option>
                    <option value="Ноутбук">Ноутбук</option>
                    <option value="Компьютер">Компьютер</option>
                    <option value="Принтер">Принтер / МФУ</option>
                    <option value="Смартфон">Смартфон</option>
                    <option value="Телевизор">Телевизор</option>
                    <option value="Холодильник">Холодильник</option>
                    <option value="Авто">Автоэлектроника</option>
                    <option value="Другое">Другое</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Год выпуска</label>
                <input type="number" name="manufacture_year" min="1980" max="2026" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Состояние</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="condition" value="new" checked> Новое
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="condition" value="used"> Б/У
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="condition" value="after_repair"> После ремонта
                    </label>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Примечание</label>
                <textarea name="notes" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl"></textarea>
            </div>
        </div>

        <div class="mt-10">
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl text-lg">
                Добавить технику
            </button>
        </div>
    </form>
</div>
@endsection