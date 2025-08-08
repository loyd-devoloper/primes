<?php

namespace App\Console\Commands\Leave;

use Carbon\Carbon;
use Illuminate\Console\Command;

class EveryMonthLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prime:every-month-leave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

//        $now = Carbon::parse('12-12-2024');
        $start = Carbon::now()->format('F Y');


        // $startMonth = $now->firstOfMonth();
        $startMonth =Carbon::now()->firstOfMonth();
        $endMonth =Carbon::now()->lastOfMonth();
        $end =Carbon::now()->lastOfMonth()->format('F d, Y');

        $users = \App\Models\User::whereHas('leavePointLatest', function ($query){
            $query->whereYear('created_at',Carbon::now())->where('sync',1);
        })->select('id_number')->whereHas('workExperienceCurrent', function ($query) {
            $query->where('status_appointment', 'Permanent');
        })->with('leavePointLatestCto')->get();

        foreach ($users as $user) {
            \App\Models\Leave\LeaveCard::query()
                ->updateOrCreate(

                    [
                        'id_number' => $user->id_number,
                        'period' => $start,
                        'vl_balance' => $user->leavePointLatest?->vl,
                        'sl_balance' =>  $user->leavePointLatest?->sl,
                        'cto_balance' =>  $user->leavePointLatestCto?->sum('points'),
                    ],
                    [
                        'period' => $start,
                        'start_date' => $startMonth,
                        'id_number' => $user->id_number,
                         'particulars'=>"Balance Forwarded"
                    ]
                );
                \App\Models\Leave\LeaveCard::query()
                ->updateOrCreate(
                    [
                        'id_number' => $user->id_number,
                        'period' => $end,
                    ],
                    [
                        'period' => $end,
                        'start_date' => $endMonth,
                        'id_number' => $user->id_number,
                        // 'particulars'=>"Balance Forwarded"
                    ]
                );
        }
    }
}
