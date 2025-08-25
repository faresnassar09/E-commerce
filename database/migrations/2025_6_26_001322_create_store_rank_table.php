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
        Schema::create('store_rank', function (Blueprint $table) {

            $table->id();
            
            $table->foreignId('store_id')
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            
            $table->integer("total_sales");
            $table->integer("total_quantity");
            $table->timestamps();





        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_rank');
    }
};
