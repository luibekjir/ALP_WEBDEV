<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('receiver_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('destination')->nullable();
            $table->string('courier')->nullable();
            $table->integer('shipping_cost')->default(0);
            $table->string('payment_method')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
