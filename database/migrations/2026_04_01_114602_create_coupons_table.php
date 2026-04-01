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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id('coupon_id');

            $table->string('code')->unique(); // SAVE10

            $table->integer('discount');
            $table->enum('type', ['percent', 'fixed']);

            $table->date('expiry_date')->nullable();

            $table->integer('usage_limit')->nullable(); // total allowed usage
            $table->integer('used_count')->default(0);

            $table->enum('status', ['0', '1'])
                ->default('1')
                ->comment('0 = inactive, 1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
