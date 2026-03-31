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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');

          
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Product relation
            $table->unsignedBigInteger('proid');

            // Rating + Review
            $table->tinyInteger('rating'); // 1 to 5 stars
            $table->text('review')->nullable();



            

            $table->timestamps();

            $table->unique(['user_id', 'proid']);


            $table->foreign('proid')
                  ->references('proid')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
