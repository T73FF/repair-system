@extends('layouts.app')

@section('title', 'Склад запчастей')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Склад запчастей</h1>
        <a href="{{ route('spare-parts.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-plus"></i> Добавить запчасть
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Артикул</th>
                    <th class="px-6 py-4 text-left">Название</th>
                    <th class="px-6 py-4 text-left">Бренд</th>
                    <th class="px-6 py-4 text-left">Категория</th>
                    <th class="px-6 py-4 text-left">Цена продажи</th>
                    <th class="px-6 py-4 text-left">На складе</th>
                    <th class="px-6 py-4 text-left">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($spareParts as $part)
                <tr class="hover:bg-gray-50 @if($part->stock_quantity <= $part->min_stock) bg-red-50 @endif">
                    <td class="px-6 py-4 font-mono">{{ $part->article }}</td>
                    <td class="px-6 py-4 font-medium">{{ $part->name }}</td>
                    <td class="px-6 py-4">{{ $part->brand ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $part->category ?? '—' }}</td>
                    <td class="px-6 py-4 font-semibold">{{ number_format($part->sale_price, 2) }} ₽</td>
                    <td class="px-6 py-4">
                        <span class="font-bold {{ $part->stock_quantity <= $part->min_stock ? 'text-red-600' : 'text-green-600' }}">
                            {{ $part->stock_quantity }}
                        </span>
                        @if($part->stock_quantity <= $part->min_stock)
                            <span class="text-red-500 text-xs">(мало)</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('spare-parts.edit', $part) }}" class="text-amber-600 hover:underline">Редактировать</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-500">На складе пока ничего нет</td></tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>
@endsection