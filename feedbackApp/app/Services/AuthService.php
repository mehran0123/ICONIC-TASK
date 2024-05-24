<?php

use App\Models\Customer;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthService extends BaseService
{
    public function Login($request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('authToken')->plainTextToken;

                $users['id'] = $user->id;
                $users['name'] = $user->name;
                $users['email'] = $user->email;
                $user['token_name'] = 'Bearer';
                $users['token']= $token;
                return $users;
            } else {
                return $this->addErrors(['Unauthorized']);
            }
        } catch (\Exception $e) {
            return  $this->addErrors([$e->getMessage()]);
        }
    }

}
