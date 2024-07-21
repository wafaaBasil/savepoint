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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->enum('coupon_type',['coupon','advertisement'])->default('coupon');
            $table->string('image')->nullable();
            $table->string('name');
            $table->enum('type',['percent','fixed'])->default('percent');
            $table->double('discount');
            $table->double('top_discount')->nullable();
            $table->integer('provider_id');
            $table->integer('product_id')->nullable();
            $table->timestamp('end_date');
            $table->integer('num_of_use')->nullable();
            $table->boolean('active')->default(1);
            $table->enum('status', ['new', 'accept', 'reject'])->default('new');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
