<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'name' => env('APP_NAME', 'РемонтСервис'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', true),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    'timezone' => 'Europe/Moscow',   // ← Изменил на московское время

    'locale' => 'ru',

    'fallback_locale' => 'ru',

    'faker_locale' => 'ru_RU',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'maintenance' => [
        'driver' => 'file',
    ],

    'providers' => ServiceProvider::defaultProviders()->merge([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        
        // Добавляем провайдер для DomPDF
        Barryvdh\DomPDF\ServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // Добавляем фасад для PDF
        'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
    ])->toArray(),

];