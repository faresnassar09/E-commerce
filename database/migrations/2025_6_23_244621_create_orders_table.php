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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->onDelete('cascade');

            $table->foreignId(
                'seller_id'
            )->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId(
                'store_id'
            )->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                
            $table->foreignId(
                'user_address_id'
            )->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->integer('price');
            $table->integer('status')->default(1);
            $table->string('comments', 255);
            $table->date("time_to_delevired");
            $table->string('payment_method');
            $table->string('order_number');
            $table->string('backup_phone_number', 60);
            $table->string('comment', 255);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
