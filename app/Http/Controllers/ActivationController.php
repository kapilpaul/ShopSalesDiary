<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activateUser($email, $activationCode){

        $user = User::whereEmail($email)->first();

        //$sentinelUser = Sentinel::findById($user->id);

        if(Activation::complete($user, $activationCode)){
            return redirect('/login')->with(['success' => 'Activation Successful']);
        }else{
            return redirect('/login')->with(['error' => 'Invalid Activation Key']);
        }

    }
}
