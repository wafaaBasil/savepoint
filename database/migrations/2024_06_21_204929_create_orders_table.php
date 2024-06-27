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
            $table->integer('customer_id');
            $table->integer('provider_id');
            $table->integer('delivery_id');
            $table->integer('payment_method_id')->nullable();
            $table->double('order_price');
            $table->double('delivery_price');
            $table->integer('copon_id')->nullable();
            $table->double('total');
            $table->enum('status', ['جاري التجهيز', 'التوصيل', 'تم التوصيل', 'جديد']);
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
