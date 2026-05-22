<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Отчёт</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Отчёт по сервису — {{ now()->format('d.m.Y H:i') }}</h1>

    <h2>Основные показатели</h2>
    <p><strong>Всего заявок:</strong> {{ $totalOrders }}</p>
    <p><strong>Выручка:</strong> {{ number_format($totalRevenue, 2) }} ₽</p>
    <p><strong>Прибыль:</strong> {{ number_format($totalProfit, 2) }} ₽</p>

    <h2>Топ-10 запчастей</h2>
    <table>
        <tr><th>Запчасть</th><th>Кол-во</th></tr>
        @foreach($topParts as $part)
        <tr>
            <td>{{ $part->name }} ({{ $part->article }})</td>
            <td>{{ $part->total_qty }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Топ-10 клиентов</h2>
    <table>
        <tr><th>Клиент</th><th>Заявок</th><th>Сумма</th></tr>
        @foreach($topClients as $client)
        <tr>
            <td>{{ $client->name }}</td>
            <td>{{ $client->orders_count }}</td>
            <td>{{ number_format($client->total_spent, 2) }} ₽</td>
        </tr>
        @endforeach
    </table>
</body>
</html>