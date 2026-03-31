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
        Schema::create('contacts', function (Blueprint $table) {
                   
            $table->id('contact_id');

            // Optional user (if login)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');

            
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            
            $table->string('subject')->nullable();
            $table->text('message');

            $table->enum('status', ['pending', 'in_progress', 'resolved'])
                  ->default('pending');
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
