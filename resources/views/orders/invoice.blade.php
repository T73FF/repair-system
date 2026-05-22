<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чек №{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            padding: 40px;
            color: #333;
            position: relative;
        }
        .watermark {
            position: fixed;
            bottom: 50%;
            right: 10%;
            opacity: 0.08;
            transform: rotate(-45deg);
            font-size: 70px;
            z-index: 0;
            white-space: nowrap;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
        }
        .info {
            margin-bottom: 30px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items th, .items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items th {
            background: #f3f4f6;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            color: #999;
            font-size: 12px;
        }
        .qr-code {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }
        .qr-code p {
            font-size: 10px;
            color: #666;
        }
        .invoice-number {
            font-size: 11px;
            color: #888;
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="watermark">ОРИГИНАЛ</div>
    
    <div class="invoice-number">
        Чек №{{ $order->invoice_number ?? $order->order_number . '-И' }}
    </div>

    <div class="header">
        <h1>РемонтСервис</h1>
        <p>Акт выполненных работ №{{ $order->order_number }}</p>
        <p>Дата формирования: {{ now()->format('d.m.Y H:i:s') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150"><strong>Клиент:</strong></td>
                <td>{{ $order->client->name }}</td>
            </tr>
            <tr>
                <td><strong>Телефон:</strong></td>
                <td>{{ $order->client->phone }}</td>
            </tr>
            <tr>
                <td><strong>Техника:</strong></td>
                <td>{{ $order->equipment->brand }} {{ $order->equipment->model }}</td>
            </tr>
            <tr>
                <td><strong>Описание проблемы:</strong></td>
                <td>{{ $order->problem_description }}</td>
            </tr>
            <tr>
                <td><strong>Дата приёма:</strong></td>
                <td>{{ $order->created_at->format('d.m.Y') }}</td>
            </tr>
        </table>
    </div>

    <h3>Выполненные работы и запчасти</h3>
    <table class="items">
        <thead>
            <tr>
                <th>Наименование</th>
                <th width="80">Кол-во</th>
                <th width="100">Цена</th>
                <th width="120">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->service_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} ₽</td>
                <td>{{ number_format($item->total, 2) }} ₽</td>
            </tr>
            @endforeach
            @foreach($order->spareParts as $item)
            <tr>
                <td>{{ $item->sparePart->name }} (запчасть)</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price_per_unit, 2) }} ₽</td>
                <td>{{ number_format($item->total, 2) }} ₽</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        ИТОГО К ОПЛАТЕ: {{ number_format($order->total_amount, 2) }} ₽
    </div>

    @if($order->paid_amount > 0)
        <div class="total" style="border-top: none;">
            Оплачено: {{ number_format($order->paid_amount, 2) }} ₽
        </div>
    @endif

    @if(isset($qrCodeBase64) && $qrCodeBase64)
    <div class="qr-code" style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd;">
    <img src="{{ $qrCodeBase64 }}" width="150" alt="QR-код проверки чека">
    <p style="font-size: 10px; color: #666;">Отсканируйте QR-код для проверки подлинности чека</p>
    </div>
    @endif

    <div class="footer">
        <p>Спасибо, что выбрали РемонтСервис!</p>
        <p>Гарантия на работы 12 месяцев</p>
        <p>Чек сформирован автоматически, подпись не требуется</p>
    </div>
</body>
</html>