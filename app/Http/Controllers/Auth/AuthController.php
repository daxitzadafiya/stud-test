<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
	public function login(Request $request)
	{
        $remember = $request->get('remember_me');

		$credentials = $request->only('email', 'password');

		if (! auth()->attempt($credentials, $remember)) {
            activity('login_failed')
            ->withProperties(['email' =>  $request->only('email')])
            ->log('login fail');
            return $this->sendFail('The given data was invalid.', [
                'email' => __('auth.failed'),
            ], 422);
        }


        $user = auth()->user();
        if(!in_array($user->role, ['E','SA','A'])){
            activity('login_failed')
            ->withProperties(['email' =>  $request->only('email')])
            ->log('login fail');
            return $this->sendFail('The given data was invalid.', [
                'email' => __('auth.failed'),
            ], 422);
        }
        if ($user) {
            $user->last_login_at = Carbon::now();
            $user->save();
        }

        $accessToken = auth()->user()->createToken('userAuthToken')->plainTextToken;

        $data = [
            'message' => __('Authenticated successfully.'),
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ];

        activity("login_success")
        ->withProperties(['email' =>  $request->only('email')])
        ->log('login success');

        return $this->sendResponse($data);
	}

    public function show()
    {
    	return $this->sendResponse([
            'user' => new UserResource($user),
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        auth('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return $this->sendResponse();
        return new JsonResponse('user logout', 204);
    }
}
