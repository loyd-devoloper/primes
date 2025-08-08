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
        Schema::create('recruitment_application_eligibilities', function (Blueprint $table) {
            $table->id();
            $table->string('application_code');
            $table->json('education');
            $table->text('education_remarks')->nullable();
            $table->boolean('education_status')->nullable();
            $table->text('training_remarks')->nullable();
            $table->boolean('training_status')->nullable();
            $table->text('experience_remarks')->nullable();
            $table->boolean('experience_status')->nullable();
            $table->text('eligibility_remarks')->nullable();
            $table->boolean('eligibility_status')->nullable();
            $table->json('training');
            $table->json('experience');
            $table->json('eligibility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_application_eligibilities');
    }
};
