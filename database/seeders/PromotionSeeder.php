<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        Promotion::create([
            'title' => '🔥 Скидка 10% на первый ремонт!',
            'description' => 'Для новых клиентов. Промокод: FIRST10',
            'code' => 'FIRST10',
            'discount_percent' => 10,
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
            'is_active' => true,
            'background_color' => '#6366f1',
            'text_color' => '#ffffff',
        ]);

        Promotion::create([
            'title' => '🎉 Весенняя распродажа!',
            'description' => 'Скидка 500₽ на любой ремонт от 3000₽',
            'code' => 'SPRING500',
            'discount_amount' => 500,
            'starts_at' => now(),
            'expires_at' => now()->addDays(15),
            'is_active' => true,
            'background_color' => '#ec4899',
            'text_color' => '#ffffff',
        ]);
    }
}