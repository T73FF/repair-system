<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('code')->unique();
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->boolean('is_active')->default(true);
            $table->string('background_color')->default('#6366f1');
            $table->string('text_color')->default('#ffffff');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};