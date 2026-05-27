<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id'); // Who reports
            $table->unsignedBigInteger('reported_profile_id'); // Profile being reported
            $table->string('reason'); // Reason for report
            $table->text('description')->nullable(); // Optional details
            $table->timestamps();

            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reported_profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_reports');
    }
};
