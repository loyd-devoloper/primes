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
        Schema::create('leave_bulk_dtrs', function (Blueprint $table) {
            $table->id();
            $table->string('batch');
            $table->string('id_number');
            $table->json('dtr');
            $table->string('date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_bulk_dtrs');
    }
};
