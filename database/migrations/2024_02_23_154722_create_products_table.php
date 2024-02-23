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
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('unit_price');
            $table->decimal('unit_discount')->default(0.00);
            $table->text('available_size');
            $table->text('available_colors');
            $table->integer('unit_in_stock');
            $table->integer('unit_weight')->default(0);
            $table->integer('unit_on_order')->default(0);
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('sub_category')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('sub_category')->references('id')->on('categories')->nullOnDelete();
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
