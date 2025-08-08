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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->string('id_number',50);
            $table->string('division_code',100)->nullable();
            $table->text('lname')->nullable();
            $table->text('fname')->nullable();
            $table->text('mname')->nullable();
            $table->string('name_extension',10)->nullable();
            $table->text('birth_date')->nullable();
            $table->string('place_birth',200)->nullable();
            $table->string('citizenship',200)->nullable();
            $table->string('sex',10)->nullable();
            $table->string('civil_status',100)->nullable();
            $table->string('height',10)->nullable();
            $table->string('weight',10)->nullable();
            $table->string('blood_type',10)->nullable();
            $table->text('gsis_no')->nullable();
            $table->text('pag_ibig_no')->nullable();
            $table->text('philhealth_no')->nullable();
            $table->text('sss_no')->nullable();
            $table->text('tin_no')->nullable();
            $table->text('agency_employee_no')->nullable();
            $table->text('telephone_no')->nullable();
            $table->text('mobile_no')->nullable();
            $table->string('contact_person_name',50)->nullable();
            $table->text('contact_person_address')->nullable();
            $table->text('contact_person_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
