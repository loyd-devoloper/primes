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
        Schema::create('leave_ctos', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('subject');
            $table->string('points');
            $table->string('status')->nullable();
            $table->string('effective_date');
            $table->string('expired_date');
            $table->text('attachment')->nullable();
              $table->string('bulk_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_ctos');
    }
};
