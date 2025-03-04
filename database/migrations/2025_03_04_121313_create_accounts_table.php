<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // PK
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // FK
            $table->string('currency'); // Валюта счета (RUB, USD, EUR)
            $table->decimal('balance', 15, 2)->default(0.00); // Баланс счета
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
