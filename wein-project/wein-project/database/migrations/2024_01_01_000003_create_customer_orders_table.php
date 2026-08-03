<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id')->constrained('orders')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('cart_url')->nullable();
            $table->longText('notes')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('delivery_price', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('password_hash');
            $table->string('phone_number');
            $table->string('location')->nullable();
            $table->boolean('is_updated')->default(false);
            $table->timestamp('updated_by_customer_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};
