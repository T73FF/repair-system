<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
public function index()
{
    $totalOrders = RepairOrder::count();
    $totalRevenue = RepairOrder::sum('total_amount');

    // Прибыль
    $totalCost = \DB::table('order_spare_parts')
                    ->join('spare_parts', 'spare_parts.id', '=', 'order_spare_parts.spare_part_id')
                    ->sum(\DB::raw('order_spare_parts.quantity * spare_parts.purchase_price'));

    $totalProfit = $totalRevenue - ($totalCost ?? 0);

    $statusStats = RepairOrder::select('status', \DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->get();

    // Топ запчастей
    $topParts = \DB::table('order_spare_parts')
                    ->join('spare_parts', 'spare_parts.id', '=', 'order_spare_parts.spare_part_id')
                    ->select('spare_parts.name', 'spare_parts.article', 
                             \DB::raw('SUM(order_spare_parts.quantity) as total_qty'),
                             \DB::raw('SUM(order_spare_parts.total) as total_revenue'))
                    ->groupBy('spare_parts.name', 'spare_parts.article')
                    ->orderByDesc('total_qty')
                    ->limit(10)
                    ->get();

    // Топ клиентов
    $topClients = RepairOrder::select('clients.name', 
                        \DB::raw('COUNT(repair_orders.id) as orders_count'), 
                        \DB::raw('SUM(repair_orders.total_amount) as total_spent'))
                    ->join('clients', 'clients.id', '=', 'repair_orders.client_id')
                    ->groupBy('clients.name')
                    ->orderByDesc('total_spent')
                    ->limit(10)
                    ->get();

    return view('reports.index', compact(
        'totalOrders', 
        'totalRevenue', 
        'totalProfit',
        'totalCost',
        'statusStats', 
        'topParts', 
        'topClients'
    ));
}

public function exportPdf()
{
    $totalOrders = RepairOrder::count();
    $totalRevenue = RepairOrder::sum('total_amount');

    $totalCost = \DB::table('order_spare_parts')
                    ->join('spare_parts', 'spare_parts.id', '=', 'order_spare_parts.spare_part_id')
                    ->sum(\DB::raw('order_spare_parts.quantity * spare_parts.purchase_price'));

    $totalProfit = $totalRevenue - ($totalCost ?? 0);

    $topParts = \DB::table('order_spare_parts')
                    ->join('spare_parts', 'spare_parts.id', '=', 'order_spare_parts.spare_part_id')
                    ->select('spare_parts.name', 'spare_parts.article', 
                             \DB::raw('SUM(order_spare_parts.quantity) as total_qty'))
                    ->groupBy('spare_parts.name', 'spare_parts.article')
                    ->orderByDesc('total_qty')
                    ->limit(10)
                    ->get();

    $topClients = RepairOrder::select('clients.name', 
                        \DB::raw('COUNT(repair_orders.id) as orders_count'), 
                        \DB::raw('SUM(repair_orders.total_amount) as total_spent'))
                    ->join('clients', 'clients.id', '=', 'repair_orders.client_id')
                    ->groupBy('clients.name')
                    ->orderByDesc('total_spent')
                    ->limit(10)
                    ->get();

    $pdf = \PDF::loadView('reports.pdf', compact(
        'totalOrders', 'totalRevenue', 'totalProfit', 'totalCost', 'topParts', 'topClients'
    ));

    return $pdf->download('otchet-' . now()->format('Y-m-d_H-i') . '.pdf');
}

}