<?php

namespace App\Services\api;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\password;

class AuthService extends BaseService
{
    public function Login($request)
    {

        try {
            $credentials = ['email'=> request()->get('email'),'password' => request()->get('password')];
            if (Auth::attempt($credentials)) {
                $user = User::where('email', request()->get('email'))->first();
                $token = $user->createToken('authToken')->plainTextToken;

                $userData['id'] = $user->id;
                $userData['name'] = $user->name;
                $userData['email'] = $user->email;
                $userData['token_name'] = 'Bearer';
                $userData['token'] = $token;
                return $userData;
            } else {
                return $this->addErrors(['Invalid credentials']);
            }
        } catch (\Exception $e) {
            return $this->addErrors([$e->getMessage()]);
        }
    }

}
