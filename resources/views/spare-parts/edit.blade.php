@extends('layouts.app')

@section('title', 'Редактировать запчасть')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Редактировать запчасть</h1>

    <form method="POST" action="{{ route('spare-parts.update', $sparePart) }}" class="bg-white rounded-2xl shadow p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Те же поля, что и в create, но с value -->

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Артикул</label>
                <input type="text" name="article" value="{{ $sparePart->article }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl font-mono">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Бренд</label>
                <input type="text" name="brand" value="{{ $sparePart->brand }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Название запчасти</label>
                <input type="text" name="name" value="{{ $sparePart->name }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Цена закупки</label>
                <input type="number" name="purchase_price" step="0.01" value="{{ $sparePart->purchase_price }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Цена продажи</label>
                <input type="number" name="sale_price" step="0.01" value="{{ $sparePart->sale_price }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Количество на складе</label>
                <input type="number" name="stock_quantity" value="{{ $sparePart->stock_quantity }}" min="0" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Минимальный остаток</label>
                <input type="number" name="min_stock" value="{{ $sparePart->min_stock }}" min="0" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                <input type="text" name="category" value="{{ $sparePart->category }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Примечание</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl">{{ $sparePart->notes }}</textarea>
            </div>
        </div>

        <div class="mt-10 flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl">
                Сохранить изменения
            </button>
            <a href="{{ route('spare-parts.index') }}" 
               class="flex-1 text-center border border-gray-300 py-4 rounded-2xl hover:bg-gray-50">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection