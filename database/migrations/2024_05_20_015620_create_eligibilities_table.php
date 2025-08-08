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
        Schema::create('eligibilities', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('license_title')->nullable();
            $table->string('rating')->nullable();
            $table->string('date_examination')->nullable();
            $table->string('place_examination')->nullable();
            $table->string('license_number')->nullable();
            $table->string('date_validity')->nullable();
            $table->string('type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligibilities');
    }
};
