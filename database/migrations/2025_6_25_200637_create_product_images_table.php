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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("product_id")
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string("path");
            $table->timestamps();


  
        });
    }

    /**

     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
