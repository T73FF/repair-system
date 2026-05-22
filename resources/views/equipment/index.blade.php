@extends('layouts.app')

@section('title', 'Техника')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Вся техника</h1>
        <a href="{{ route('equipment.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-plus"></i> Добавить технику
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Клиент</th>
                    <th class="px-6 py-4 text-left">Бренд / Модель</th>
                    <th class="px-6 py-4 text-left">Серийный номер</th>
                    <th class="px-6 py-4 text-left">Категория</th>
                    <th class="px-6 py-4 text-left">Состояние</th>
                    <th class="px-6 py-4 text-left">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($equipment as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $item->client->name ?? '-' }}</td>
                    <td class="px-6 py-4 font-medium">{{ $item->brand }} {{ $item->model }}</td>
                    <td class="px-6 py-4">{{ $item->serial_number ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $item->category }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs 
                            @if($item->condition == 'new') bg-green-100 text-green-700
                            @elseif($item->condition == 'after_repair') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $item->condition }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline">Открыть</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-500">Техники пока нет</td></tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>
@endsection