<?php

namespace App\Livewire\Recruitment\Step1;

use App\Models\Recruitment_Job;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CheckFile extends Component
{
    public function render()
    {
        $jobs = Cache::remember('recruitment_step1_checkfile',24*60,function(){
            return Recruitment_Job::orderBy('id','desc')->get();
        });
        return view('livewire.recruitment.step1.check-file',compact('jobs'));
    }
}
