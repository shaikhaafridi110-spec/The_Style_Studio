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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();

    // FIXED coupon relation
    $table->unsignedBigInteger('coupon_id');
    $table->foreign('coupon_id')
          ->references('coupon_id')
          ->on('coupons')
          ->onDelete('cascade');

    // user relation
    $table->foreignId('user_id')
          ->constrained('users')
          ->onDelete('cascade');

    // order relation
    $table->foreignId('order_id')
          ->constrained('orders')
          ->onDelete('cascade');

    $table->timestamps();

    $table->unique(['coupon_id', 'user_id']);
    $table->unique('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
