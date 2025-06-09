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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('stadium_name')->nullable();
            $table->string('stadium_capacity')->nullable();
            $table->string('city');
            $table->string('country');
            $table->year('founded_year')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
}; 