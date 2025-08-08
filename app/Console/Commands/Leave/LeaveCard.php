<?php

namespace App\Console\Commands\Leave;

use Carbon\Carbon;
use Illuminate\Console\Command;

class LeaveCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prime:leave-card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yearly: transfer leave points';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $now = Carbon::now();
        $start = $now->format('F Y');


        $startMonth = $now->firstOfMonth();
        $users = \App\Models\User::query()
            ->whereHas('leavePointLatest', function ($query) {
                $query->whereYear('created_at', Carbon::now()->subYears(1));
            })->select('id_number')->whereHas('workExperienceCurrent', function ($query) {
                $query->where('status_appointment', 'Permanent');
            })
            ->with(['leavePointLatest'])->get();

        foreach ($users as $user)
        {

            $check = \App\Models\User::query()
                ->whereHas('leavePointLatest', function ($query) {
                    $query->whereYear('created_at', Carbon::now())->where('sync',1);
                })
                ->where('id_number', $user->id_number)
                ->select('id_number')
                ->whereHas('workExperienceCurrent', function ($query) {
                    $query->where('status_appointment', 'Permanent');
                })
                ->with(['leavePointLatest'])
                ->first();
            if($check == null)
            {
                \App\Models\LeaveEmployee::query()->updateOrCreate(['id_number' => $user->id_number,'created_at' => Carbon::now()],[
                    'sl' => $user->leavePointLatest?->sl,
                    'vl' =>  $user->leavePointLatest?->vl,
                    'fl' =>  $user->leavePointLatest?->fl,
                    'spl' =>  $user->leavePointLatest?->spl,
                    'e_sign'=>$user->leavePointLatest?->e_sign,
                    'year'=>Carbon::now()->format('Y')
                ]);
            }
            ;
        }
    }
}
