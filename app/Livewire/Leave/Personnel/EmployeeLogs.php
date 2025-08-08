<?php

namespace App\Livewire\Leave\Personnel;

use Livewire\Component;

class EmployeeLogs extends Component
{
    public $activities = [];


    public function render()
    {
        return view('livewire.leave.personnel.employee-logs');
    }
}
