<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->json('preferences_new')->nullable()->after('profession');
        });

        // Optional: copy old data
        DB::statement("
            UPDATE profiles
            SET preferences_new = JSON_OBJECT('raw', preferences)
        ");

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('preferences');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('preferences_new', 'preferences');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('preferences')->nullable();
        });
    }
};

