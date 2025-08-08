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
        Schema::create('leave_employees', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('sl')->nullable();
            $table->string('vl')->nullable();
            $table->string('fl')->nullable();
            $table->string('spl')->nullable();
            $table->string('e_sign')->nullable();
            $table->string('current_month')->nullable();
                $table->boolean('status')->default(0);
            $table->string('year')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_employees');
    }
};
