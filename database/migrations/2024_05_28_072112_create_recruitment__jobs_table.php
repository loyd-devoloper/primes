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
        Schema::create('recruitment__jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('job_id');
            $table->string('job_title');

            $table->string('plantilla_item')->nullable();
            $table->string('salary_grade')->nullable();
            $table->string('place_of_assignment');
            $table->string('status_of_appointment');
            $table->string('application_code');
            $table->string('education');
            $table->string('training');
            $table->string('experience');
            $table->string('eligibility');
            $table->boolean('status_of_hiring')->default(0);

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment__jobs');
    }
};
