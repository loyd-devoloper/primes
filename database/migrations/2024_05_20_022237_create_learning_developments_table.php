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
        Schema::create('learning_developments', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->text('title')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('number_hours')->nullable();
            $table->string('type_ld')->nullable();
            $table->string('conducted_by')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_developments');
    }
};
