@extends('layouts.app')

@section('title', 'Клиенты')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Клиенты</h1>
        <a href="{{ route('clients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-plus"></i> Новый клиент
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Имя</th>
                    <th class="px-6 py-4 text-left">Телефон</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Заявок</th>
                    <th class="px-6 py-4 text-left">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $client->name }}</td>
                    <td class="px-6 py-4">{{ $client->phone }}</td>
                    <td class="px-6 py-4">{{ $client->email ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $client->repair_orders_count }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline mr-4">Просмотр</a>
                        <a href="{{ route('clients.edit', $client) }}" class="text-amber-600 hover:underline">Редактировать</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-500">Клиентов пока нет</td></tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>
@endsection