<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spare_part_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_spare_parts');
    }
};