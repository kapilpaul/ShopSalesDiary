<?php

namespace App\Http\Controllers;

use App\Http\Requests\registerUserRequest;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function postRegister(Request $request){
        $user = Sentinel::register($request->all());

        $activation = Activation::create($user);

        $role = Sentinel::findRoleBySlug('admin');

        $role->users()->attach($user);

        $this->sendEmail($user, $activation->code);

        return redirect('/');
    }

    public function sendEmail($user, $code){
        $mail_data = [
            'user' => $user,
            'code' => $code,
        ];

        Mail::send('email/activation', $mail_data, function($message) use ($user){
            $message->to($user->email)->subject("Hello $user->name activate your account");
        });
    }


}
