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
        //id,userid, Age, gender, religion, community, profession, location, and marital status,created_at
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->integer('age_from')->nullable(true);
            $table->integer('age_to')->nullable(true);
            $table->enum('gender', ['Male', 'Female'])->nullable(true);
            $table->string('religion')->nullable(true);
            $table->string('community')->nullable(true);
            $table->string('profession')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('city')->nullable(true);
            $table->enum('marital_status', ['single', 'divorced', 'widow'])->default('single')->nullable(true);
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
