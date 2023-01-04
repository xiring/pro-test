<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            return $this->loginResponse();
        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        return $request->wantsJson()
            ? $this->loginResponse()
            : redirect()->intended($this->redirectPath());
    }

    private function loginResponse()
    {
        $user = auth()->user();
        $data['message'] = 'Logged in successfully';
        $data['user'] = $user;
        $data['token'] = $user->createToken('ApiToken')->accessToken;
        $data['permissions'] = $user->getAllPermissions()->pluck('name','id');
        return response($data, 200);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
        return response()->json([
            'message' => 'User is already logged out'
        ]);
    }
}
