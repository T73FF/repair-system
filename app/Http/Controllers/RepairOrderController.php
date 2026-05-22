<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\SparePart;
use App\Notifications\TestPushNotification;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class RepairOrderController extends Controller
{
    public function index()
    {
        $query = RepairOrder::with(['client', 'equipment']);

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('client', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('equipment', fn($q) => 
                      $q->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                  );
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $orders = $query->latest()->paginate(15);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $clients = Client::all();
        $equipment = Equipment::all();
        return view('orders.create', compact('clients', 'equipment'));
    }

    public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'equipment_id' => 'required|exists:equipment,id',
        'problem_description' => 'required|string',
        'repair_type' => 'required|in:warranty,paid,maintenance',
        'deadline' => 'nullable|date',
    ]);

    // Генерируем номер заявки
    $orderNumber = 'R-' . date('Y') . '-' . str_pad(RepairOrder::count() + 1, 4, '0', STR_PAD_LEFT);
    
    // Генерируем номер чека
    $invoiceNumber = 'ЧК-' . date('Y') . '-' . str_pad(RepairOrder::count() + 1, 6, '0', STR_PAD_LEFT);

    $order = RepairOrder::create([
        'order_number' => $orderNumber,
        'invoice_number' => $invoiceNumber,  // ← ДОБАВЬ ЭТУ СТРОКУ
        'client_id' => $request->client_id,
        'equipment_id' => $request->equipment_id,
        'created_by' => auth()->id(),
        'problem_description' => $request->problem_description,
        'repair_type' => $request->repair_type,
        'deadline' => $request->deadline,
        'status' => 'new',
        'total_amount' => 0,
    ]);

    return redirect()->route('orders.index')
                     ->with('success', 'Заявка №' . $orderNumber . ' успешно создана!');
}

    public function show(RepairOrder $order)
    {
        $user = auth()->user();

        if ($user->hasRole('client')) {
            if ($order->client_id !== $user->client?->id) {
                abort(403, 'Доступ запрещён. Это не ваша заявка.');
            }
        }

        $order->load(['client', 'equipment', 'items', 'spareParts.sparePart']);

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, RepairOrder $order)
    {
        if (auth()->user()->hasRole('client')) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'status' => 'required|in:new,diagnostic,in_progress,waiting_parts,ready,issued,cancelled',
            'comment' => 'nullable|string'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // ==================== ОТПРАВКА PUSH-УВЕДОМЛЕНИЯ ====================
        $client = $order->client;
        // ВРЕМЕННО: прямая отправка без очереди
        if ($client && $client->user) {
        $user = $client->user;
        if ($user->pushSubscriptions()->exists()) {
        $statusNames = [
            'new' => '📋 Новая',
            'diagnostic' => '🔍 На диагностике',
            'in_progress' => '🔧 В работе',
            'waiting_parts' => '⏳ Ожидает запчасти',
            'ready' => '✅ Готов к выдаче',
            'issued' => '🎉 Выдан',
            'cancelled' => '❌ Отменена',
        ];
        $statusText = $statusNames[$request->status] ?? $request->status;
        
        // Прямая отправка (минуя очередь)
        $channel = new \NotificationChannels\WebPush\WebPushChannel();
        $channel->send($user, new TestPushNotification(
            'Статус заявки изменён',
            "Заявка №{$order->order_number} → {$statusText}",
            route('client.order.show', $order)
        ));
    }
}
        // ==================================================================

        $order->statusHistory()->create([
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'changed_by' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Статус успешно изменён!');
    }

    public function addItem(Request $request, RepairOrder $order)
    {
        if (auth()->user()->hasRole('client')) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'service_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
        ]);

        $total = $request->price * $request->quantity;

        $order->items()->create([
            'service_name' => $request->service_name,
            'price'        => $request->price,
            'quantity'     => $request->quantity,
            'total'        => $total,
        ]);

        $this->recalculateOrderTotal($order);

        return back()->with('success', 'Работа успешно добавлена!');
    }

    public function addSparePart(Request $request, RepairOrder $order)
    {
        if (auth()->user()->hasRole('client')) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity'      => 'required|integer|min:1',
        ]);

        $part = SparePart::findOrFail($request->spare_part_id);

        if ($part->stock_quantity < $request->quantity) {
            return back()->with('error', 'На складе недостаточно запчастей! Доступно: ' . $part->stock_quantity);
        }

        $total = $part->sale_price * $request->quantity;

        $order->spareParts()->create([
            'spare_part_id' => $part->id,
            'quantity'      => $request->quantity,
            'price_per_unit'=> $part->sale_price,
            'total'         => $total,
        ]);

        $part->decrement('stock_quantity', $request->quantity);

        $this->recalculateOrderTotal($order);

        return back()->with('success', 'Запчасть добавлена и списана со склада!');
    }

    private function recalculateOrderTotal(RepairOrder $order)
    {
        $itemsTotal = $order->items()->sum('total');
        $partsTotal = $order->spareParts()->sum('total');
        $order->update(['total_amount' => $itemsTotal + $partsTotal]);
    }

    public function clientShow(RepairOrder $order)
    {
        $user = auth()->user();

        if ($user->hasRole('client') && $order->client_id !== $user->client?->id) {
            abort(403, 'Это не ваша заявка.');
        }

        $order->load(['client', 'equipment', 'items', 'spareParts.sparePart']);

        return view('orders.client-show', compact('order'));
    }

public function downloadInvoice(RepairOrder $order)
{
    $user = auth()->user();
    
    if ($user->hasRole('client') && $order->client_id !== $user->client?->id) {
        abort(403, 'Это не ваша заявка.');
    }
    
    $order->load(['client', 'equipment', 'items', 'spareParts.sparePart']);
    
    // Генерируем QR-код в формате SVG (не требует imagick/gd)
    $qrCodeSvg = QrCode::format('svg')
        ->size(150)
        ->margin(2)
        ->generate(route('client.order.show', $order));
    
    // Кодируем в base64 для вставки в PDF
    $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
    
    $pdf = \PDF::loadView('orders.invoice', compact('order', 'qrCodeBase64'));
    
    return $pdf->download('cheque-' . $order->order_number . '.pdf');
}
}