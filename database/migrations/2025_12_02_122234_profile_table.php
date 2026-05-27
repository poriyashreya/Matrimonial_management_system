<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('religion');
            $table->string('community');
            $table->enum('marital_status', ['single', 'divorced', 'widow'])->default('single');
            $table->string('profession');
            $table->text('preferences');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->boolean('verified_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
