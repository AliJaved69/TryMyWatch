<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The column may be missing on databases created before it was added
        // to the create_orders_table migration.
        if (Schema::hasColumn('orders', 'order_number')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('id');
        });

        // Backfill existing rows with unique tracking numbers.
        DB::table('orders')->whereNull('order_number')->orderBy('id')->each(function ($order) {
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['order_number' => 'TMW-' . strtoupper(Str::random(8))]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unique('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['order_number']);
            $table->dropColumn('order_number');
        });
    }
};
