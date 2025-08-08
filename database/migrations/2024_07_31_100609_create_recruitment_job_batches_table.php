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
        Schema::create('recruitment_job_batches', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id');
            $table->string('job_id');
            $table->string('batch_name');
            $table->string('status');
            $table->string('closing_date')->nullable();
            $table->string('posting_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_job_batches');
    }
};
