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
        Schema::create('leave_advance_settings', function (Blueprint $table) {
            $table->id();
            // Minutes
            $table->string('min1',10)->nullable();
            $table->string('min2',10)->nullable();
            $table->string('min3',10)->nullable();
            $table->string('min4',10)->nullable();
            $table->string('min5',10)->nullable();
            $table->string('min6',10)->nullable();
            $table->string('min7',10)->nullable();
            $table->string('min8',10)->nullable();
            $table->string('min9',10)->nullable();
            $table->string('min10',10)->nullable();
            $table->string('min11',10)->nullable();
            $table->string('min12',10)->nullable();
            $table->string('min13',10)->nullable();
            $table->string('min14',10)->nullable();
            $table->string('min15',10)->nullable();
            $table->string('min16',10)->nullable();
            $table->string('min17',10)->nullable();
            $table->string('min18',10)->nullable();
            $table->string('min19',10)->nullable();
            $table->string('min20',10)->nullable();
            $table->string('min21',10)->nullable();
            $table->string('min22',10)->nullable();
            $table->string('min23',10)->nullable();
            $table->string('min24',10)->nullable();
            $table->string('min25',10)->nullable();
            $table->string('min26',10)->nullable();
            $table->string('min27',10)->nullable();
            $table->string('min28',10)->nullable();
            $table->string('min29',10)->nullable();
            $table->string('min30',10)->nullable();
            $table->string('min31',10)->nullable();
            $table->string('min32',10)->nullable();
            $table->string('min33',10)->nullable();
            $table->string('min34',10)->nullable();
            $table->string('min35',10)->nullable();
            $table->string('min36',10)->nullable();
            $table->string('min37',10)->nullable();
            $table->string('min38',10)->nullable();
            $table->string('min39',10)->nullable();
            $table->string('min40',10)->nullable();
            $table->string('min41',10)->nullable();
            $table->string('min42',10)->nullable();
            $table->string('min43',10)->nullable();
            $table->string('min44',10)->nullable();
            $table->string('min45',10)->nullable();
            $table->string('min46',10)->nullable();
            $table->string('min47',10)->nullable();
            $table->string('min48',10)->nullable();
            $table->string('min49',10)->nullable();
            $table->string('min50',10)->nullable();
            $table->string('min51',10)->nullable();
            $table->string('min52',10)->nullable();
            $table->string('min53',10)->nullable();
            $table->string('min54',10)->nullable();
            $table->string('min55',10)->nullable();
            $table->string('min56',10)->nullable();
            $table->string('min57',10)->nullable();
            $table->string('min58',10)->nullable();
            $table->string('min59',10)->nullable();
            $table->string('min60',10)->nullable();
            // Hours
            $table->string('hours1',10)->nullable();
            $table->string('hours2',10)->nullable();
            $table->string('hours3',10)->nullable();
            $table->string('hours4',10)->nullable();
            $table->string('hours5',10)->nullable();
            $table->string('hours6',10)->nullable();
            $table->string('hours7',10)->nullable();
            $table->string('hours8',10)->nullable();
            $table->string('hours9',10)->nullable();
            $table->string('hours10',10)->nullable();
            // Months
            $table->string('month1',10)->nullable();
            $table->string('month2',10)->nullable();
            $table->string('month3',10)->nullable();
            $table->string('month4',10)->nullable();
            $table->string('month5',10)->nullable();
            $table->string('month6',10)->nullable();
            $table->string('month7',10)->nullable();
            $table->string('month8',10)->nullable();
            $table->string('month9',10)->nullable();
            $table->string('month10',10)->nullable();
            $table->string('month11',10)->nullable();
            $table->string('month12',10)->nullable();
            // Days
            $table->string('days1',10)->nullable();
            $table->string('days2',10)->nullable();
            $table->string('days3',10)->nullable();
            $table->string('days4',10)->nullable();
            $table->string('days5',10)->nullable();
            $table->string('days6',10)->nullable();
            $table->string('days7',10)->nullable();
            $table->string('days8',10)->nullable();
            $table->string('days9',10)->nullable();
            $table->string('days10',10)->nullable();
            $table->string('days11',10)->nullable();
            $table->string('days12',10)->nullable();
            $table->string('days13',10)->nullable();
            $table->string('days14',10)->nullable();
            $table->string('days15',10)->nullable();
            $table->string('days16',10)->nullable();
            $table->string('days17',10)->nullable();
            $table->string('days18',10)->nullable();
            $table->string('days19',10)->nullable();
            $table->string('days20',10)->nullable();
            $table->string('days21',10)->nullable();
            $table->string('days22',10)->nullable();
            $table->string('days23',10)->nullable();
            $table->string('days24',10)->nullable();
            $table->string('days25',10)->nullable();
            $table->string('days26',10)->nullable();
            $table->string('days27',10)->nullable();
            $table->string('days28',10)->nullable();
            $table->string('days29',10)->nullable();
            $table->string('days30/31',10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_advance_settings');
    }
};
