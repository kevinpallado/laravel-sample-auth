<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
// mails
use App\Mail\AccountVerifier;
// models
use App\Models\User;
//jobs
use App\Jobs\TrailUserLogs;
/**
 * @group Authorization
 * 
 * Login and logout authorization to access commercial API
 **/
class AuthenticationController extends Controller
{
    private $loginAction = 'Login';
    private $logoutAction = 'Logout';


    /**
     * Sign Up
     * 
     * Register User
     */
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required'
        ]);

        $emailToken = Str::random(64);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'remember_token' => $emailToken
        ]);

        $token = $user->createToken('commercialToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        Mail::to($fields['email'])->send(new AccountVerifier($emailToken));

        return response($response, 201);
    }

    /**
     * User Login
     * 
     * Only registered user can login
     **/
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!auth()->attempt($fields)){
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        TrailUserLogs::dispatch($this->loginAction, $this->ipAddress, $user);

        $token = $user->createToken('commercialToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * User Logout
     * 
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     */
    public function logout(Request $request){

        TrailUserLogs::dispatch($this->logoutAction, $this->ipAddress, $request->user());

        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged out', 201]);
    }

    public function verifyAccount(Request $request) {
        $verifyUser = User::where('remember_token', $request->token)->firstOrFail();
        if($verifyUser) {
            $verifyUser->email_verified_at = Carbon::now();
            $verifyUser->save();
            return response(['message' => 'Email successfully verified']);
        }
    }
}
