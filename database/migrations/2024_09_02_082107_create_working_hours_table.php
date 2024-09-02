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
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('day_id');
            $table->enum('mode',['specificHours','closed','alwaysOpen'])->default('closed');
            $table->time('morningStart')->nullable();
            $table->time('morningEnd')->nullable();
            $table->time('eveningStart')->nullable();
            $table->time('eveningEnd')->nullable();
            $table->integer('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
