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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('id_number',50);
            $table->text('device')->nullable();
            $table->text('device_version')->nullable();
            $table->text('browser')->nullable();
            $table->text('browser_version')->nullable();
            $table->text('device_type')->nullable();
            $table->text('ip')->nullable();
            $table->string('activity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
