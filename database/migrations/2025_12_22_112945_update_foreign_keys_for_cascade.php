<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('filters', function (Blueprint $table) {

            // 🔴 First drop old foreign key (important)
            $table->dropForeign(['profile_id']);

            // ✅ Re-add with ON DELETE CASCADE
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('filters', function (Blueprint $table) {

            // Drop cascade FK
            $table->dropForeign(['profile_id']);

            // Re-add without cascade (original behavior)
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles');
        });
    }
};
