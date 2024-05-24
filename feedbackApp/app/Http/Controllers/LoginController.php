<?php

namespace App\Http\Controllers;

use App\libs\Response\GlobalApiResponse;
use App\libs\Response\GlobalApiResponseCodeBook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:web')->except('logout');
    }

    public function login(Request $request)
    {
        $data = $this->authService->Login($request->all());
        if ($this->authService->hasError())
            return (new GlobalApiResponse())->error(GlobalApiResponseCodeBook::INVALID_CREDENTIALS, 'INVALID CREDENTIALS', $this->authService->getErrors());
        return (new GlobalApiResponse())->success('User logged in Successfully!', 1,$data);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
       // Auth::logout();
        return true;
    }
}
