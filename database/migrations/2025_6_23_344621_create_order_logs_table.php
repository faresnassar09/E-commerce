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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("order_id")
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            $table->string("title");
            $table->string("details",255);
            $table->string('type',20);
            $table->timestamps();





        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_logs');
    }
};
