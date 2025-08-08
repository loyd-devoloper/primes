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
        Schema::table('recruitment_job_batches', function (Blueprint $table) {
            $table->text('car_file')->after('posting_date')->nullable();
            $table->text('notification_letter')->after('posting_date')->nullable();
            $table->string('hired_applicant_id')->after('posting_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_job_batches', function (Blueprint $table) {
            //
        });
    }
};
