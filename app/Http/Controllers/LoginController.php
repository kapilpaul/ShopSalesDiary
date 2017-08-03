<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use League\Flysystem\Exception;
use Sentinel;
use App\Http\Requests\loginUserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function postLogin(loginUserRequest $request){
        try{
            $remember_me = false;
            if(isset($request->remember_me))
                $remember_me = true;

            if(Sentinel::authenticate($request->all(), $remember_me)){

                if(Sentinel::getUser()->roles()->first()->slug == 'admin')
                    return redirect('/index');
                else
                    return Sentinel::getUser();
            }else{
                return redirect()->back()->with(['error' => 'Wrong Credentials']);
            }
        }catch(ThrottlingException $e){
            $delay = $e->getDelay();

            return redirect()->back()->with(['error' => "You are banned for $delay seconds"]);
        }catch(NotActivatedException $e){
            return redirect()->back()->with(['error' => "Your account is not activated yet."]);
        }
    }

    public function logout(){
        Sentinel::logout();

        return redirect('/login');
    }
}
