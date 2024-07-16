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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('male.jpg');
            $table->string('name');
            $table->enum('type',['percent','fixed'])->default('percent');
            $table->string('url')->nullable();
            $table->integer('provider_id');
            $table->date('start_date');
            $table->integer('num_of_day');
            $table->text('details');
            $table->boolean('active')->default(1);
            $table->enum('status', ['مؤكد', 'بانتظار الدفع']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
