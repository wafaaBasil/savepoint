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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('male.jpg');
            $table->string('name');
            $table->enum('type', ['restaurant', 'cafe'])->default('restaurant');
            $table->string('commercial_register');
            $table->text('overview');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('manager_name');
            $table->string('manager_phonenumber');
            //$table->string('address')->nullable();
            //$table->decimal('latitude', 10, 8)->nullable();
            //$table->decimal('longitude', 11, 8)->nullable();
            //$table->integer('provider_id')->nullable();
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
        Schema::dropIfExists('providers');
    }
};
