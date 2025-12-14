<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Receiver (snapshot per order)
            $table->string('receiver_name')->nullable();
            $table->string('phone')->nullable();

            // Address snapshot
            $table->text('address')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            // Shipping
            $table->string('courier')->nullable();
            $table->integer('shipping_cost')->default(0);

            // Payment
            $table->string('payment_method')->nullable();

            // Order info
            $table->integer('total_price')->default(0);
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
