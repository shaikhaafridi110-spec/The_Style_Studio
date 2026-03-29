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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            //user relation
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            //Order info
            $table->string('order_number')->unique();

            // price status show
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            // Payment 
            $table->enum('payment_method', ['cod', 'upi', 'card'])
                ->default('cod'); 
            $table->enum('payment_status', ['pending', 'paid', 'failed'])
                ->default('pending');

            // Order status
            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Address snapshot
            $table->string('name');
            $table->string('phone');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');

            // Tracking
            $table->string('tracking_number')->nullable();

            // Dates
            $table->timestamp('order_date')->useCurrent();
            $table->timestamp('delivered_at')->nullable();

            // Extra
            $table->text('notes')->nullable();

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
