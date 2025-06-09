<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notifications_enabled')->default(true);
            $table->boolean('email_notifications')->default(true);
            $table->foreignId('default_league_id')->nullable()->constrained('leagues')->nullOnDelete();
            $table->string('language', 2)->default('pl');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['default_league_id']);
            $table->dropColumn([
                'notifications_enabled',
                'email_notifications',
                'default_league_id',
                'language',
            ]);
        });
    }
}; 