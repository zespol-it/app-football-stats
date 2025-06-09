<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('logo')->nullable();
            $table->string('level')->default('1'); // Poziom rozgrywek (1, 2, 3...)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leagues');
    }
}; 