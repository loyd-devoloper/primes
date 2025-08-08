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
        Schema::create('recruitment_monitorings', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(0);
            $table->string('unfilled_position')->nullable();
            $table->string('dbm_plantilla_item_number')->nullable();
            $table->string('salary_grade')->nullable();
            $table->string('year_of_vacancy_posting')->nullable();
            $table->string('date_of_publication')->nullable();
            $table->string('issuance_of_regional_memo')->nullable();
            $table->string('deadline_on_the_submmision_of_application')->nullable();
            $table->string('initial_evaluation_applicants_hrmpsb')->nullable();
            $table->string('initial_evaluation_of_applicants_end_user')->nullable();
            $table->text('recruitment_remarks')->nullable();


            $table->string('office_memo_to_the_hrmpsb')->nullable();
            $table->string('open_ranking_assessment')->nullable();
            $table->string('hrmpsb_deliberation')->nullable();


            $table->string('car')->nullable();
            $table->string('memo_to_and_memo_for')->nullable();
            $table->string('minutes_of_the_meeting')->nullable();
            $table->string('justification_resolution')->nullable();
            $table->string('letter_to_the_successfull_candidate')->nullable();
            $table->text('selection_remarks')->nullable();


            $table->string('appointment')->nullable();
            $table->string('pdf')->nullable();
            $table->string('cert_of_assumtion_to_duty')->nullable();
            $table->string('supporting_documents')->nullable();
            $table->string('placement_remarks')->nullable();


            $table->string('to_csc_of_rizal')->nullable();
            $table->string('to_csc_of_remarks')->nullable();
            $table->string('turn_around_time')->nullable();


            $table->uuid('batch_id');
            $table->string('job_id');
            $table->timestamps();
        });





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_monitorings');
    }
};
