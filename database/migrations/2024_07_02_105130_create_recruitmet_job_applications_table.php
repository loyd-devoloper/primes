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
        Schema::create('recruitmet_job_applications', function (Blueprint $table) {
            $table->id()->from(100);
            $table->string('application_code')->nullable();
            $table->string('batch_id');
            $table->text('fname');
            $table->text('mname')->nullable();
            $table->text('lname');
            $table->string('religion')->nullable();
            $table->string('disability')->nullable();
            $table->string('ethnic_group')->nullable();
            $table->text('email');
            $table->text('mobile_number');
            $table->text('address');
            $table->string('sex');
            $table->string('birthdate');
            $table->string('civil_status');

            $table->text('letter_of_intent')->nullable();
            $table->boolean('letter_of_intent_status')->default(0);

            $table->text('pds')->nullable();
            $table->boolean('pds_status')->default(0);

            $table->text('prc')->nullable();
            $table->boolean('prc_status')->default(0);

            $table->text('eligibility')->nullable();
            $table->boolean('eligibility_status')->default(0);

            $table->text('tor')->nullable();
            $table->boolean('tor_status')->default(0);

            $table->text('training_attended')->nullable();
            $table->boolean('training_attended_status')->default(0);

            $table->text('certificate_of_employment')->nullable();
            $table->boolean('certificate_of_employment_status')->default(0);

            $table->text('latest_appointment')->nullable();
            $table->boolean('latest_appointment_status')->default(0);


            $table->text('performance_rating')->nullable();
            $table->boolean('performance_rating_status')->default(0);

            $table->text('cav')->nullable();
            $table->boolean('cav_status')->default(0);

            $table->text('awards_recognition')->nullable();
            $table->text('research_innovation')->nullable();
            $table->text('membership_in_national')->nullable();
            $table->text('resource_speakership')->nullable();
            $table->text('neap')->nullable();
            $table->text('application_of_education')->nullable();
            $table->text('l_and_d')->nullable();
            $table->boolean('movs_status')->default(0);

            $table->char('job_id',36);
            $table->boolean('application_status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitmet_job_applications');
    }
};
