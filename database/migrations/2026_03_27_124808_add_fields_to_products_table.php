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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('category')->after('name')->default('pulsa');
            $table->decimal('price', 15, 2)->after('category')->default(0);
            $table->string('status')->after('price')->default('active');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'category', 'price', 'status']);
        });
    }
};
