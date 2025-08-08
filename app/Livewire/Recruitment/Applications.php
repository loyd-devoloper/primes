<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\Recruitment_Job;
use Illuminate\Support\Facades\Cache;

class Applications extends Component
{
    public function render()
    {

            $jobs =  Recruitment_Job::withCount(['checkFile'=>function($q){
                $q->where('application_status','0');
            },'validator'=>function($q){
                $q->where('application_status','1');
            },'qualified'=>function($q){
                $q->where('application_status','2');
            }])->orderBy('id','desc')->get();



        return view('livewire.recruitment.applications',compact('jobs'));
    }
}
