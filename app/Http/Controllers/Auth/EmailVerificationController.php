<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialize;
use Request;
use App\User;
use Auth;
use Session;
use Mail;

class EmailVerificationController extends Controller {


	/*
	|--------------------------------------------------------------------------
	| Email validation controller
	|--------------------------------------------------------------------------
	|
	|
	*/



    public function emailValidation($activation_code)
    {
        $user = User::where('activation_code','=',$activation_code)->first();
        if (!empty($user)) {
            $user->active = 1;
            $user->activation_code = '';
            if ($user->save()) {
                Auth::login($user);
                flash()->success('Yay! Your account has now been fully activated!');
                return redirect()->route('base');
            }
        } 

        flash()->error('Activation code not found');
        return redirect()->route('base');
    }

    public function resendValidationEmail()
    {
        $user = Auth::user();
        if (!$user->active) {
            Mail::queueOn('email_validations','emails.account_activation', array('activation_code'=>$user->activation_code),function($message) use ($user) {
                $message->from('no-reply@gafers.com','Gafers');
                $message->to($user->email, $user->username)->subject('Verification code!');
            });
            flash()->success('Verification email has been sent. Within 15 minutes you will recieve an email with your verification code');
        } 
        return redirect()->back();
    }
	

}
