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
        Schema::create('recruitment_job_other_infotmations', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id');
            $table->string('job_id');
            $table->string('venue')->nullable();
            $table->string('initial_evaluation')->nullable();
            $table->string('open_ranking')->nullable();
            $table->string('exam')->nullable();
            $table->string('interview')->nullable();

             // open ranking form
             $table->string('type');
             $table->string('category');
             $table->string('min_requirements_education');
             $table->string('min_requirements_training');
             $table->string('min_requirements_experience');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_job_other_infotmations');
    }
};
