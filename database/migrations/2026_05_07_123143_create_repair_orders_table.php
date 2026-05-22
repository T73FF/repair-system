<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('technicians');
            $table->foreignId('created_by')->constrained('users');

            $table->enum('status', [
                'new', 
                'diagnostic', 
                'in_progress', 
                'waiting_parts', 
                'ready', 
                'issued', 
                'cancelled'
            ])->default('new');

            $table->enum('repair_type', ['warranty', 'paid', 'maintenance'])->default('paid');

            $table->text('problem_description');
            $table->text('diagnostic_result')->nullable();
            $table->text('work_done')->nullable();

            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);

            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repair_orders');
    }
};