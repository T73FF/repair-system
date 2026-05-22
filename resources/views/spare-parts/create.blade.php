@extends('layouts.app')

@section('title', 'Добавить запчасть')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Добавить новую запчасть на склад</h1>

    <form method="POST" action="{{ route('spare-parts.store') }}" class="bg-white rounded-2xl shadow p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Артикул <span class="text-red-500">*</span></label>
                <input type="text" name="article" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl font-mono">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Бренд</label>
                <input type="text" name="brand" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Название запчасти <span class="text-red-500">*</span></label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Цена закупки (себестоимость)</label>
                <input type="number" name="purchase_price" step="0.01" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Цена продажи <span class="text-red-500">*</span></label>
                <input type="number" name="sale_price" step="0.01" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Количество на складе <span class="text-red-500">*</span></label>
                <input type="number" name="stock_quantity" value="0" min="0" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Минимальный остаток</label>
                <input type="number" name="min_stock" value="5" min="0" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                <input type="text" name="category" placeholder="Экраны, Аккумуляторы, Клавиатуры и т.д." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Примечание</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl"></textarea>
            </div>
        </div>

        <div class="mt-10">
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl text-lg">
                Добавить на склад
            </button>
        </div>
    </form>
</div>
@endsection