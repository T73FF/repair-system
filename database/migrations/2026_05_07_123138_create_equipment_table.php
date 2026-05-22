<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->unique()->nullable();
            $table->string('category'); // ноутбук, принтер, автомобиль и т.д.
            $table->integer('manufacture_year')->nullable();
            $table->json('photos')->nullable(); // массив путей к фото
            $table->enum('condition', ['new', 'used', 'after_repair'])->default('used');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};