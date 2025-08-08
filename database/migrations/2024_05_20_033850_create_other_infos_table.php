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
        Schema::create('other_infos', function (Blueprint $table) {
            $table->id();
            $table->string('id_number', 50);
            $table->string('no34_a', 10)->nullable();
            $table->string('no34_b', 10)->nullable();
            $table->string('no34_b_yes_details', 255)->nullable();
            $table->string('no35_a', 10)->nullable();
            $table->string('no35_a_yes_details', 255)->nullable();
            $table->string('no35_b', 10)->nullable();
            $table->string('no35_b_date_filed', 255)->nullable();
            $table->string('no35_b_case_status', 255)->nullable();
            $table->string('no36_a', 10)->nullable();
            $table->string('no36_a_yes_details', 255)->nullable();
            $table->string('no37_a', 10)->nullable();
            $table->string('no37_a_yes_details', 255)->nullable();
            $table->string('no38_a', 10)->nullable();
            $table->string('no38_a_yes_details', 255)->nullable();
            $table->string('no38_b', 10)->nullable();
            $table->string('no38_b_yes_details', 255)->nullable();
            $table->string('no39_a', 10)->nullable();
            $table->string('no39_a_yes_details', 255)->nullable();
            $table->string('no40_a', 10)->nullable();
            $table->string('no40_a_yes_details', 255)->nullable();
            $table->string('no40_b', 10)->nullable();
            $table->string('no40_b_yes_details', 255)->nullable();
            $table->string('no40_c', 10)->nullable();
            $table->string('no40_c_yes_details', 255)->nullable();
            $table->string('c_ref1_name', 255)->nullable();
            $table->string('c_ref1_address', 255)->nullable();
            $table->string('c_ref1_tel', 255)->nullable();
            $table->string('c_ref2_name', 255)->nullable();
            $table->string('c_ref2_address', 255)->nullable();
            $table->string('c_ref2_tel', 255)->nullable();
            $table->string('c_ref3_name', 255)->nullable();
            $table->string('c_ref3_address', 255)->nullable();
            $table->string('c_ref3_tel', 255)->nullable();
            $table->string('e_sig', 200)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_infos');
    }
};
