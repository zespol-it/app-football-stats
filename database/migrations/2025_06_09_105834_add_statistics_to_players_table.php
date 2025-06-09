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
        Schema::table('players', function (Blueprint $table) {
            $table->integer('goals')->default(0)->after('is_active');
            $table->integer('assists')->default(0)->after('goals');
            $table->integer('yellow_cards')->default(0)->after('assists');
            $table->integer('red_cards')->default(0)->after('yellow_cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['goals', 'assists', 'yellow_cards', 'red_cards']);
        });
    }
};
