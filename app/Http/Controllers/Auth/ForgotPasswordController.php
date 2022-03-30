<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Mail\EmailResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    protected $resetPageUrl;
    protected $resetLinkSent = false;

    public function __construct()
    {
        $this->resetPageUrl = config('myconfig.soken-front').'/reset-password/';
    }

    public function __invoke(ForgotPasswordRequest $request)
    {
        Password::broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                Mail::to($user->email)
                    ->send(new EmailResetPassword($this->resetPageUrl . $token . '/' . encrypt($user->email), $user));

                $this->resetLinkSent = true;
            }
        );

        return $this->resetLinkSent
            ? $this->sendResponse(['message' => __('Reset link sent to your email.')])
            : $this->sendError(__('Unable to send reset link.'), 500);
    }
}
