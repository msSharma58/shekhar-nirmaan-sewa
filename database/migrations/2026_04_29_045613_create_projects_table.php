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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->enum('category', ['residential','commercial','renovation','civil']);
            $table->enum('status',   ['completed','ongoing','planning'])->default('planning');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('featured')->default(true);
            $table->date('completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
