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
        //id,sender_id,reciver_id,accept,reject,request,Canceled

        Schema::create("user_request", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->tinyInteger('is_pending')->default(1); // 1 for pending, 0 for not pending
            $table->tinyInteger('is_accepted')->default(0); // 1 for accepted, 0 for not accepted
            $table->tinyInteger('is_rejected')->default(0); // 1 for rejected, 0 for not rejected
            $table->tinyInteger('is_canceled')->default(0); // 1 for canceled, 0 for not canceled
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('profiles')->onDelete('cascade');
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
