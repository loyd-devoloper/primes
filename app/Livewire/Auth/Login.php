<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\OtpEnum;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Traits\ActivityTrait;
use App\Mail\VerificationMain;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use App\Models\VerificationCode;
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;
use Spatie\GoogleCalendar\Event;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Filament\Notifications\Notification;
use Symfony\Contracts\Service\Attribute\Required;

class Login extends Component
{
    use ActivityTrait;

    public $email;

    public $password;
    public $data_privacy;

    public string $turnstileResponse = '';

    public function rules()
    {
        return [
            'email'=>'required|email',
            'password'=>'required',
            'data_privacy'=>'required|accepted',
//             'turnstileResponse' =>['required', Rule::turnstile()]
        ];
    }
    public function mount()
    {

        exec('php artisan icon:cache');
        if (Auth::check()) {
            return redirect()->route('personnel.home');
        }
    }

    public function employee_login()
    {

        $this->validate();

        $apiData =  Http::get(env('TEAHUB_URL').'/api/login-request/$2y$10$cLeGKQPtcL1mXbaAGp6NDeKml4EEN0468YrdSSLnjlMfZNxLgC/' . $this->email . '/' . $this->password);
        $result = json_decode($apiData);

        if ($result->status == 200) {

            // check if register na
            $user =  User::where('email', $result->data->email)->first();
            //user existed na, need to update only
            if ($user) {
                User::where('email', $result->data->email)
                    ->update([
                        'name' => $result->data->fname . ' ' . $result->data->lname,
                        'email' => $result->data->email,
                        'password' => $result->data->password,
                        'user_type' => $result->data->user_level,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'fd_code' => $result->data->fd_code,
                        'status' => $result->data->account_status
                    ]);

            }
            //new user
            else {
                $user = User::create([
                    'name' => $result->data->fname . ' ' . $result->data->lname,
                    'id_number' => Str::uuid(),
                    'email' => $result->data->email,
                    'password' => $result->data->password,
                    'user_type' =>  $result->data->user_level,
                    'created_at' => date('Y-m-d H:i:s'),
                    'fd_code' => $result->data->fd_code,
                    'status' => $result->data->account_status
                ]);

            }



            $check = VerificationCode::where('email', $result->data->email)->where('user_id', $user->id_number)->orderBy('id', 'desc')->first();
            if ($check) {
                if (!!$check->verified_at && $check->status == 1) {
                    $checkTime = Carbon::now()->diffInMinutes(Carbon::parse($check->verified_at));

                    if ($checkTime > 30) {

                        $code = rand(100000, 999999);

                        Mail::to($result->data->email)->queue(new VerificationMain($code));
                        $check->update(['status' => 0, 'verified_at' => null, 'code' => $code,]);
                        $this->redirectRoute('auth.otp', ['id' => Crypt::encryptString($check->id)]);
                    } else {

                        Auth::login($user);

                        $this->storeActivityLog('Login');
                        Auth::logoutOtherDevices($this->password);
                        $this->redirectRoute('auth.login');
                    }
                } else {
                    $diff =  Carbon::parse($check->updated_at)->diffInMinutes(Carbon::now()) * 60;
                    $diffSeconds =  Carbon::parse($check->updated_at)->diffInSeconds(Carbon::now());


                    $total = $diff - $diffSeconds;

                    $fixMinus = (10 * 60) - $diffSeconds;
                    if ($fixMinus < 0) {
                        $code = rand(100000, 999999);
                        Mail::to($result->data->email)->queue(new VerificationMain($code));
                        $check->update(['status' => 0, 'verified_at' => null, 'code' => $code]);

                        $this->redirectRoute('auth.otp', ['id' => Crypt::encryptString($check->id)]);
                    } else {
                        $this->redirectRoute('auth.otp', ['id' => Crypt::encryptString($check->id)]);
                    }
                }
            } else {
                $code = rand(100000, 999999);

                $check = VerificationCode::create([
                    'email' => $result->data->email,
                    'user_id' => $user->id_number,
                    'code' => $code,

                ]);

                Mail::to($result->data->email)->queue(new VerificationMain($code));

                $this->redirectRoute('auth.otp', ['id' => Crypt::encryptString($check->id)]);
            }
        }
        // return 404
        else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'email' => [$result->remarks],
            ]);
            throw $error;
        }
    }

    #[Title('Login')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
