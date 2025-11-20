<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->text('address');
        $table->text('items')->nullable(); // store cart items JSON or text
        $table->decimal('total_price', 10, 2)->default(0);
          $table->string('payment_method')->default('cod');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
