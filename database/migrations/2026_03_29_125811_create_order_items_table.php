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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');



            // product fields
            $table->unsignedBigInteger('product_id');// unsignedBigInteger becouse some error is coming.
            
                
            $table->string('product_name');
            $table->string('product_image')->nullable();

            $table->decimal('original_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2);

            $table->integer('qty');

            // size
            $table->string('size')->nullable();

            $table->decimal('subtotal', 10, 2); // final_price * qty
            $table->enum('status', [
                'active',
                'cancelled'
            ])->default('active');
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
