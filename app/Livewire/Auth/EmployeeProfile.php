<?php

namespace App\Livewire\Auth;

use App\Models\Address;
use Livewire\Component;
use App\Models\UserInfo;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class EmployeeProfile extends Component
{
    protected $id;
    public function mount($id)
    {
        $this->id = Crypt::decrypt($id);


    }
    #[Title('Employee Basic Information ')]
    public function render()
    {
        $userInfo = UserInfo::select('sex','birth_date','citizenship')
                    ->where('id_number',$this->id)->first();
                    $user = DB::table("users")
                    ->select('name','email','profile')
                    ->where('id_number',$this->id)->first();

        $residential =Address::select('street','city','province')
                    ->where('id_number',$this->id)
                    ->where('type','RESIDENTIAL')
                    ->first();
        $permanent =Address::select('street','city','province')
        ->where('id_number',$this->id)
        ->where('type','PERMANENT')
        ->first();
        return view('livewire.auth.employee-profile',compact('userInfo','permanent','residential','user'));
    }
}
