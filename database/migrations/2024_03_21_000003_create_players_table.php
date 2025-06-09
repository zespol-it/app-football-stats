<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')->nullable();
            $table->date('birth_date');
            $table->string('birth_place')->nullable();
            $table->string('nationality');
            $table->string('position'); // FW, MF, DF, GK
            $table->string('shirt_number')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // w cm
            $table->decimal('weight', 5, 2)->nullable(); // w kg
            $table->string('preferred_foot')->nullable(); // left, right, both
            $table->text('biography')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}; 