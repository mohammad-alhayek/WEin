<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instant_order_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instant_order_id')->constrained('instant_orders')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('phone_number');
            $table->string('location')->nullable();
            $table->integer('quantity')->default(1);
            $table->longText('notes')->nullable();
            $table->string('password_hash');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instant_order_reservations');
    }
};
