<?php

namespace App\Console\Commands\Leave;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Cto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prime:cto_expired';

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
        \App\Models\Leave\Cto::whereDate('expired_date',Carbon::now())->update([
            'status'=>\App\Enums\CtoStatusEnum::EXPIRED->value
        ]);


    }
}
