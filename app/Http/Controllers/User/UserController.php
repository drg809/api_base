<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SaveBookingHotel;
use App\Jobs\SendEmailJob;
use App\Mail\UserMail;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/** 
 * @group User
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Login user
     * @bodyParam email email required The email of the user.
     * @bodyParam password string required The password of the user.
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (! $token = auth()->attempt($data)) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $user = User::find(auth()->user()->user_id)
        ->update([
            'last_connection' => now()
        ]);

        return $this->showMessage($this->respondWithToken($token));
    }

    /**
     * Get the authenticated User
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->showMessage(auth()->user());
    }

    /**
     * Logout user (Invalidate the token)
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->showMessage(['message' => 'Successfully logged out']);
    }

    /**
     * Register new user
     * @authenticated
     * @bodyParam name string required The name of the user.
     * @bodyParam email string required The email of the user.
     * @bodyParam password string required The password of the user.
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:45', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Mail::to($data['email'])->send(new UserMail());
        //->delay(now()->addMinutes(2));

        return $this->showMessage($user, 201);
    }


    /**
     * Refresh a token
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->showMessage($this->respondWithToken(auth()->refresh()));
    }

    /**
     * Response a array with valid token
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => User::find(auth()->user()->user_id)
        ])->original;
    }
}
