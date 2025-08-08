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
        Schema::create('family_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->text('spouse_lname')->nullable();
            $table->text('spouse_fname')->nullable();
            $table->text('spouse_mname')->nullable();
            $table->string('spouse_extension')->nullable();
            $table->text('occupation')->nullable();
            $table->text('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->text('telephone_no')->nullable();
            $table->text('father_lname')->nullable();
            $table->text('father_fname')->nullable();
            $table->text('father_mname')->nullable();
            $table->string('father_extension')->nullable();
            $table->text('mother_maiden_name')->nullable();
            $table->text('mother_lname')->nullable();
            $table->text('mother_fname')->nullable();
            $table->text('mother_mname')->nullable();

            $table->string('mother_extension')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_backgrounds');
    }
};
