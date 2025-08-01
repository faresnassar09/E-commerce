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
        Schema::create('ticket_images', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('ticket_id')
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            $table->string('path',255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_images');
    }
};
