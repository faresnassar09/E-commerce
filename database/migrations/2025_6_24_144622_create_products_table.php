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

            $table->foreignId('seller_id')
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('store_id')
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            $table->foreignId('category_id')
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string("name");
            $table->string("description",1000);
            $table->float("discount")->nullable();
            $table->integer("available_quantity");
            $table->integer("sold_quantity")->default(0);
            $table->float("price");
            $table->boolean('status')->default(0);
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
