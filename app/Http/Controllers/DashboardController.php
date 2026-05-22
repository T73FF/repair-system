<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        $stats = [
            'total_orders' => RepairOrder::count(),
            'new_orders' => RepairOrder::where('status', 'new')->count(),
            'in_progress' => RepairOrder::where('status', 'in_progress')->count(),
            'ready' => RepairOrder::where('status', 'ready')->count(),
            'total_revenue' => RepairOrder::sum('total_amount'),
        ];

        $recent_orders = RepairOrder::with(['client', 'equipment'])
                            ->latest()
                            ->take(8)
                            ->get();

        return view('dashboard.index', compact('stats', 'recent_orders'));
    }

    public function clientDashboard(Request $request)
    {
        $user = auth()->user();
        
        $client = Client::where('user_id', $user->id)->first();
        
        if (!$client) {
            $client = Client::where('phone', $user->phone)->first();
            if ($client) {
                $client->user_id = $user->id;
                $client->save();
            }
        }
        
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
            ]);
        }
        
        // Фильтрация по статусу
        $query = RepairOrder::where('client_id', $client->id)->with(['equipment']);
        
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('equipment', function($eq) use ($request) {
                      $eq->where('brand', 'like', '%' . $request->search . '%')
                        ->orWhere('model', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $orders = $query->latest()->paginate(10);
        
        $statusCounts = [
            'all' => RepairOrder::where('client_id', $client->id)->count(),
            'new' => RepairOrder::where('client_id', $client->id)->where('status', 'new')->count(),
            'diagnostic' => RepairOrder::where('client_id', $client->id)->where('status', 'diagnostic')->count(),
            'in_progress' => RepairOrder::where('client_id', $client->id)->where('status', 'in_progress')->count(),
            'waiting_parts' => RepairOrder::where('client_id', $client->id)->where('status', 'waiting_parts')->count(),
            'ready' => RepairOrder::where('client_id', $client->id)->where('status', 'ready')->count(),
            'issued' => RepairOrder::where('client_id', $client->id)->where('status', 'issued')->count(),
            'cancelled' => RepairOrder::where('client_id', $client->id)->where('status', 'cancelled')->count(),
        ];
        
        $currentStatus = $request->get('status', 'all');
        
        return view('dashboard.client', compact('orders', 'statusCounts', 'currentStatus'));
    }
}