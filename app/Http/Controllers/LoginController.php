<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use League\Flysystem\Exception;
use Sentinel;
use App\Http\Requests\loginUserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        $roles = Sentinel::getRoleRepository()->get();

        if(count($roles) == 0){
            $input['slug'] = 'admin';
            $input['name'] = 'Admin';

            Sentinel::getRoleRepository()->createModel()->create($input);

            $input['slug'] = 'manager';
            $input['name'] = 'Manager';
            Sentinel::getRoleRepository()->createModel()->create($input);
        }

        $kapil = User::whereEmail("info@kapilpaul.me")->first();

        if(!$kapil){
            $kapilData['name'] = 'Kapil Paul';
            $kapilData['email'] = 'info@kapilpaul.me';
            $kapilData['password'] = 'kapil54321';

            $role = Sentinel::findRoleBySlug('admin');

            $user = Sentinel::registerAndActivate($kapilData);

            $role->users()->attach($user);
        }

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
                    return redirect('/sells');
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

        return redirect('/');
    }
}
