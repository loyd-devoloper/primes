<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Artisan;

class ValidateEmployee extends Component
{

    public $user_no;
    #[Url()]
    public $q;
    public $name;
    public function mount()
    {

        if(!!$this->q)
        {

            try {
                $checkParam = User::select('employee_id','name')->where('employee_id', Crypt::decryptString($this->q) )->first();

                if($checkParam)
                {
                    $this->name = $checkParam->name;

                }else{
                    abort(404);
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                abort(404);
            }


        }else{
            abort(404);
        }
        exec('php artisan icon:cache');
        // exec('php artisan icon:clear');
        // exec('php artisan optimize:clear');
    }
    public function validateUser()
    {

        $employeeId = $this->user_no;

        $check = DB::table("users")->get()->filter(function($q) use ($employeeId){
            $decrypt = !!$q->employee_id ? Crypt::decryptString($q->employee_id) : null;
            return $decrypt == $employeeId && !!$decrypt ? $q : null;
        })->first();

        if ($check) {

            return redirect()->route('auth.employee.profile', [ Crypt::encrypt($check->id_number)]);
        }else{
            session()->flash('no_record','not_found');
        }
    }
    #[Title('Validate Employee')]
    public function render()
    {
        return view('livewire.auth.validate-employee');
    }
}
