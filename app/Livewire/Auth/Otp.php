<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Traits\ActivityTrait;
use App\Mail\VerificationMain;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Contracts\Encryption\DecryptException;

class Otp extends Component
{
    use ActivityTrait;

    public $id;

    public $num1;
    public $num2;
    public $num3;
    public $num4;
    public $num5;
    public $num6;
    #[Locked]
    public $code;
    #[Locked]
    public $user_id;
    public $email;
    public function mount($id)
    {
        $this->id = $id;
        try {
            $payload = Crypt::decryptString($this->id);
            $verification = VerificationCode::where('id',  $payload)->first();
            $this->code = $verification->code;
            $this->user_id = $verification->user_id;
            $this->email = $verification->email;
        } catch (DecryptException $e) {
           abort(404);
        }



    }
    public function verify()
    {
        $inputCode = $this->num1 . $this->num2 . $this->num3 . $this->num4 . $this->num5 . $this->num6;

        if ($inputCode == $this->code) {
            $verification = VerificationCode::where('id', Crypt::decryptString($this->id))->update(['status' => 1, 'verified_at' => Carbon::now()]);
            $user = \App\Models\User::where('id_number', $this->user_id)->first();

            Auth::login($user);


            $this->storeActivityLog('Login');
            $this->redirectRoute('auth.login');
        } else {
            Notification::make()->title('Invalid OTP Code')->danger()->duration(5000)->send();
        }
    }
    public function resend()
    {


        $code = rand(100000, 999999);
        VerificationCode::where('id', Crypt::decryptString($this->id))->update(['status' => 0, 'verified_at' => null, 'code' => $code]);
        Notification::make()
            ->title('New OTP Code has been sent')
            ->success()
            ->duration(7000)
            ->send();
            Mail::to($this->email)->queue(new VerificationMain($code));
        return redirect()->route('auth.otp', ['id' => $this->id]);
    }

    #[Title('Verification')]
    public function render()
    {
        $verification = VerificationCode::where('id', Crypt::decryptString($this->id))->first();

        $diff =  Carbon::parse($verification->updated_at)->diffInMinutes(Carbon::now()) * 60;
        $diffSeconds =  Carbon::parse($verification->updated_at)->diffInSeconds(Carbon::now());


        $total = $diff - $diffSeconds;

        $fixMinus = (10 * 60) - $diffSeconds;
        if ($fixMinus < 0) {
            Notification::make()
                ->title('Your OTP Code has been Expired')
                ->danger()
                ->duration(8000)
                ->send();
        }
        return view('livewire.auth.otp', compact('verification', 'fixMinus'));
    }
}
