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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Define as unsigned big integer
            $table->foreign('user_id')->references('id')->on('user'); // Specify as a foreign key referencing the 'id' column in the 'users' table
            $table->date('date');
            $table->string('checkin')->nullable();
            $table->string('checkout')->nullable();
            $table->string('code');
            $table->string('activity')->nullable();
            $table->string('remark')->nullable();
            $table->string('from')->nullable();
            $table->string('std')->nullable();
            $table->string('to')->nullable();
            $table->string('sta')->nullable();
            $table->string('hotel')->nullable();
            $table->string('blh')->nullable();
            $table->string('flight_time')->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
