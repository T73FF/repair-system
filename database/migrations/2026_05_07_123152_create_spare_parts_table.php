<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->string('article')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock')->default(5);
            $table->string('category')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
};