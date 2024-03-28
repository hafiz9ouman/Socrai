<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Requests\ValidateSecretRequest;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Attachment;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     protected $redirectTo = '/admin';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');    
    }

    protected function authenticated(Request $request, Authenticatable $user)
    {
        if(Auth::user()->tfa == 1){
            $user = Auth::user();

            $name = $user->name;
            $email = $user->email;
            $new_pas = rand(100000,999999);

            DB::table('users')->where('email', $email)->update([
                "two_factor_code" =>$new_pas,
                "tfa_expire" => 0,
            ]);

            $data = ["name" => $name, "password" => $new_pas, "email" => $email];
            
            $receiver_email = $email;
            $sender_email = 'noreply@socrai.com';
            $subject = 'Socrai Notification: Two Factor Authentication Code';

            Mail::send(['html' => 'emails.signup'], $data, function ($message) use ($receiver_email, $sender_email, $subject) {
                $message->to($receiver_email, '2FA Verification')->subject($subject);
                $message->from($sender_email, 'Socrai'); // Use your sender name here
            });

            return view('2fa.2fa_code', compact("email"));
        }
        return redirect('admin');
    }
}
