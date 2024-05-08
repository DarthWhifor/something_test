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
            $table->bigIncrements('id')->primary();
            $table->foreignId('category_id')->nullable()
                ->constrained("product_categories")->cascadeOnUpdate()->nullOnDelete();
            $table->string('title', 100);
            $table->string('description', 255);
            $table->decimal('price', 5,2);
            $table->timestamps();

            $table->index('created_at');

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
