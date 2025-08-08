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
        Schema::create('tbl_fd', function (Blueprint $table) {
            $table->id();
            $table->string('division_id');
            $table->string('division_name');
            $table->string('division_short_name');
            $table->string('division_code')->nullable();
            $table->string('division_email')->nullable();
            $table->string('office_level_id');
            $table->string('fd_chief')->nullable();
            $table->string('chief_designation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_fd');
    }
};
