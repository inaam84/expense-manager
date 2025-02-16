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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('registration_number')->unique();
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->string('color');
            $table->string('engine_size');
            $table->string('fuel_type');
            $table->date('mot_due_date')->nullable();
            $table->date('tax_due_date')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
