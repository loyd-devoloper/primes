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
        Schema::create('recruitment_psb_grades', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->uuid('batch_id');
            $table->string('job_id');
            $table->string('applicant_id');
            $table->string('education');
            $table->string('education_total');
            $table->text('education_remarks')->nullable();
            $table->string('training')->nullable();
            $table->string('training_total')->nullable();
            $table->text('training_remarks')->nullable();
            $table->string('experience')->nullable();
            $table->string('experience_total')->nullable();
            $table->text('experience_remarks')->nullable();
            $table->string('performance_type')->nullable();
            $table->string('performance')->nullable();
            $table->string('performance_total')->nullable();
            $table->text('performance_remarks')->nullable();
            $table->string('outstanding')->nullable();
            $table->string('outstanding_a')->nullable()->default(0);
            $table->string('outstanding_a_remarks')->nullable();
            $table->string('outstanding2_a')->nullable()->default(0);
            $table->string('outstanding2_a_remarks')->nullable();
            $table->string('outstanding3_a')->nullable()->default(0);
            $table->string('outstanding3_a_remarks')->nullable();
            $table->string('outstanding_b')->nullable()->default(0);
            $table->string('outstanding_b_remarks')->nullable();
            $table->string('outstanding_c')->nullable()->default(0);
            $table->string('outstanding_c_remarks')->nullable();
            $table->string('outstanding_d')->nullable()->default(0);
            $table->string('outstanding_d_remarks')->nullable();
            $table->string('outstanding_e')->nullable()->default(0);
            $table->string('outstanding_e_remarks')->nullable();
            $table->string('application_of_education')->nullable();
            $table->string('application_of_education_a')->nullable()->default(0);
            $table->string('application_of_education_a_remarks')->nullable();

            $table->string('l_and_d')->nullable();
            $table->string('l_and_d_remarks')->nullable();
            $table->string('we')->nullable()->default(0);
            $table->string('wst')->nullable()->default(0);
            $table->string('bei')->nullable()->default(0);
            $table->string('potential_total')->nullable();

            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_psb_grades');
    }
};
