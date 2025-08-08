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
        Schema::create('leave_employee_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('id_number');
            $table->string('subject_title');
            $table->string('type_of_leave');
            $table->string('others')->nullable();
            $table->json('date')->nullable();
            $table->string('type_of_process')->nullable();
            $table->string('original_file')->nullable();
            $table->string('signed_file')->nullable();
            $table->text('e_sign')->nullable();
            $table->text('chief_id')->nullable();
            $table->text('chief_type')->nullable();
            $table->text('rd_id')->nullable();
            $table->text('rd_type')->nullable();
            $table->text('head_id')->nullable();
            $table->json('disapproved_remarks_head')->nullable();
            $table->json('disapproved_remarks_chief')->nullable();
            $table->json('disapproved_remarks_rd')->nullable();
            $table->string('head_status')->nullable();
            $table->string('chief_status')->nullable();
            $table->string('rd_status')->nullable();
            $table->string('status');
            $table->string('location')->nullable();
            $table->string('days')->nullable();
            $table->string('paid_days')->nullable();
            $table->string('notpaid_days')->nullable();
            $table->string('vl')->nullable();
            $table->string('fl')->nullable();
            $table->string('sl')->nullable();
            $table->string('spl')->nullable();
            $table->string('cto')->nullable();
            $table->boolean('archived')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_employee_requests');
    }
};
