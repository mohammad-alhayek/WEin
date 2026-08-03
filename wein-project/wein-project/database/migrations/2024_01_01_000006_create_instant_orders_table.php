<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instant_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('product_url')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('delivery_price', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->longText('specifications')->nullable();
            $table->string('status')->default('Available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instant_orders');
    }
};
