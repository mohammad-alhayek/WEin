<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('WEIN');
            $table->string('admin_name')->nullable();
            $table->string('admin_phone')->nullable();
            $table->timestamps();
        });

        // Insert default row
        DB::table('site_settings')->insert([
            'site_name'   => 'WEIN',
            'admin_name'  => null,
            'admin_phone' => null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
