@extends('layouts.app')

@section('title', 'Новая заявка')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Создать новую заявку</h1>

    <form method="POST" action="{{ route('orders.store') }}" class="bg-white rounded-2xl shadow p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Клиент -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Клиент</label>
                <select name="client_id" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    <option value="">Выберите клиента...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} — {{ $client->phone }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Техника -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Техника</label>
                <select name="equipment_id" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    <option value="">Выберите технику...</option>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->brand }} {{ $item->model }} ({{ $item->serial_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Тип ремонта -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Тип ремонта</label>
                <select name="repair_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                    <option value="paid">Платный</option>
                    <option value="warranty">Гарантийный</option>
                    <option value="maintenance">Профилактика</option>
                </select>
            </div>

            <!-- Срок -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Срок выполнения</label>
                <input type="date" name="deadline" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>
        </div>

        <!-- Описание проблемы -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Описание проблемы</label>
            <textarea name="problem_description" rows="5" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"></textarea>
        </div>

        <div class="mt-10">
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl text-lg">
                Создать заявку
            </button>
        </div>
    </form>
</div>
@endsection