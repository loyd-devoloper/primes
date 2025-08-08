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
        Schema::create('leave_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('start');
            $table->string('end')->nullable();
            $table->string('startTime')->nullable();
            $table->string('endTime')->nullable();
            $table->string('title');
            $table->string('id_number');
            $table->boolean('type')->default(1);
            $table->string('link')->nullable();
            $table->string('backgroundColor')->nullable();
            $table->string('display')->default('list-item')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_calendars');
    }
};
