<?php

namespace App\Console\Commands\Leave;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;

class EarnMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prime:earn-monthly';

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
        $users = User::query()->select('id', 'name', 'id_number', 'fd_code', 'profile')->with(['user_fd_code', 'leavePointLatest'])->whereHas('workExperienceCurrent', function ($query) {
            $query->where('status_appointment', 'Permanent');
        })->whereHas('leavePointLatest', function ($query) {
            $query->whereYear('created_at', Carbon::parse('12-12-2024'));
        })
        ->whereHas('workExperienceCurrent', function ($query) {
            $query->where('status_appointment', 'Permanent');
        })
        ->get();
        $currentDate = Carbon::now()->format('Y-m-d');
        foreach($users as $user)
        {
            \App\Models\Leave\LeaveEarn::updateOrCreate([
                'id_number'=>$user->id_number,
                'date'=>$currentDate
            ],[
                'id_number'=>$user->id_number,
                'date'=>$currentDate
            ]);
        }
    }
}
