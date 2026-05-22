<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Привязываем существующих клиентов к пользователям по телефону
        $clients = \App\Models\Client::whereNull('user_id')->get();
        
        foreach ($clients as $client) {
            $user = \App\Models\User::where('phone', $client->phone)->first();
            if ($user) {
                $client->update(['user_id' => $user->id]);
            }
        }
    }
};