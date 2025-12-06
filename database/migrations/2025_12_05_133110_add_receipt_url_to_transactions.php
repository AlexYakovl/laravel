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
        // Добавляем поле receipt_url в таблицу приходных операций
        Schema::table('income_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('income_transactions', 'receipt_url')) {
                $table->string('receipt_url')->nullable()->after('transaction_time');
            }
        });

        // Добавляем поле receipt_url в таблицу расходных операций
        Schema::table('expense_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('expense_transactions', 'receipt_url')) {
                $table->string('receipt_url')->nullable()->after('transaction_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Убираем поле из таблицы приходных операций (если существует)
        Schema::table('income_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('income_transactions', 'receipt_url')) {
                $table->dropColumn('receipt_url');
            }
        });

        // Убираем поле из таблицы расходных операций (если существует)
        Schema::table('expense_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('expense_transactions', 'receipt_url')) {
                $table->dropColumn('receipt_url');
            }
        });
    }
};
