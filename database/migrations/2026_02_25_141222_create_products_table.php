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
        Schema::create('products', function (Blueprint $table) {
            
            $table->id('proid');
            $table->bigInteger('catid');
            $table->string('proname');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('discount_price')->nullable()->default(0);

            $table->enum('status', ['active', 'inactive'])
      ->default('active')
      ->comment('active , inactive');

            $table->string('proimage')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
