<?php

namespace App\Http\Controllers;

use App\Traits\ActivityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ActivityTrait;
    public function logging_out(Request $request)
    {
        $this->storeActivityLog('Logout');
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
