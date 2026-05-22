<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::table('repair_orders', function (Blueprint $table) {
        $table->foreignId('created_by')->nullable()->change();
    });
    }

public function down()
    {
    Schema::table('repair_orders', function (Blueprint $table) {
        $table->foreignId('created_by')->nullable(false)->change();
    });
    }
};
