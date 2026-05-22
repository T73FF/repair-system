<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepairOrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ====================== ПУБЛИЧНАЯ ЧАСТЬ ======================
Route::get('/', function () {
    return view('clients.home');
})->name('home');

Route::get('/new-request', [PublicController::class, 'createRequest'])->name('public.request.create');
Route::post('/new-request', [PublicController::class, 'storeRequest'])->name('public.request.store');
Route::get('/check-status', [PublicController::class, 'checkStatus'])->name('public.check-status');

Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
Route::post('/apply-coupon', [PromotionController::class, 'applyCoupon'])->name('apply.coupon');

// PWA — страница при отсутствии интернета
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// ====================== АВТОРИЗАЦИЯ ======================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ====================== ЗАЩИЩЁННЫЕ МАРШРУТЫ ======================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==================== КЛИЕНТ ====================
    Route::middleware('role:client')->group(function () {
        Route::get('/client/dashboard', [DashboardController::class, 'clientDashboard'])
             ->name('client.dashboard');

        Route::get('/my-order/{order}', [RepairOrderController::class, 'clientShow'])
             ->name('client.order.show');
        
        // Скачивание чека/акта в PDF
        Route::get('/my-order/{order}/invoice', [RepairOrderController::class, 'downloadInvoice'])
             ->name('client.order.invoice');
    });

    // ==================== СОТРУДНИКИ ====================
    Route::middleware('role:admin|manager|technician')->group(function () {
        Route::resource('orders', RepairOrderController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('equipment', EquipmentController::class);
        Route::resource('spare-parts', SparePartController::class);
        
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');

        Route::patch('/orders/{order}/status', [RepairOrderController::class, 'updateStatus'])
             ->name('orders.updateStatus');
        Route::post('/orders/{order}/add-item', [RepairOrderController::class, 'addItem'])
             ->name('orders.addItem');
        Route::post('/orders/{order}/add-spare', [RepairOrderController::class, 'addSparePart'])
             ->name('orders.addSparePart');
    });
});

// ==================== PWA PUSH SUBSCRIBE ====================
Route::post('/push-subscribe', function (Request $request) {
    $user = $request->user();
    
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    $data = $request->all();
    
    $user->updatePushSubscription(
        endpoint: $data['endpoint'],
        key: $data['keys']['p256dh'],
        token: $data['keys']['auth'],
        contentEncoding: 'aesgcm'
    );
    
    return response()->json(['success' => true]);
})->middleware('auth');

// Редирект
Route::get('/home', function () {
    return redirect('/dashboard');
});