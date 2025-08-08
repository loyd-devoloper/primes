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
        Schema::create('leave_cards', function (Blueprint $table) {
            $table->id();
            $table->string('period')->nullable();
            $table->string('particulars')->nullable();
            $table->string('start_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('days')->nullable();
            $table->string('mins')->nullable();
            $table->string('hours')->nullable();
            $table->string('type')->nullable();
            $table->string('w_pay')->nullable();
            $table->string('w_o_pay')->nullable();
            $table->string('vl_earn')->nullable();
            $table->string('sl_earn')->nullable();
            $table->string('vl_balance')->nullable();
            $table->string('sl_balance')->nullable();
            $table->string('request_id')->nullable();
            $table->string('id_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_cards');
    }
};
