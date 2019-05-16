<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * @group UserForgotPassword
 *
 * APIs for managing users
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Send Reset Link Email
     * @bodyParam email email required User email.
     * @return \Illuminate\Http\JsonResponse
    */
    public function sendResetLinkEmail(Request $request)
    {
    	$data = $request->validate([
    		'email' => 'required|string|email',
    	]);

    	$response = $this->broker()->sendResetLink(
    		$request->only('email')
    	);

    	return $response == Password::RESET_LINK_SENT
    	? $this->showMessage(['message' => 'Email sent successfully!!'])
    	: $this->errorResponse('The email is not in our database.', 401);
    }

    public function broker()
    {
    	return Password::broker();
    }
}
