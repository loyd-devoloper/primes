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
        Schema::create('leave_employee_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->text('activity');
            $table->text('remarks');
            $table->boolean('type')->default(1);
            $table->text('location')->nullable();
            $table->text('link')->nullable();
            $table->string('id_number')->nullable();
            $table->string('employee_leave_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_employee_activity_logs');
    }
};
