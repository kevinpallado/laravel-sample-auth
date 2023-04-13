<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// models
use App\Models\User;
// end models
use Illuminate\Http\Request;
/**
 * @group Auth/Me/User Query
 * 
 **/
class AuthenticationUserController extends Controller
{
    /**
     * Show authenticated/logged in user its primary information
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return $this->sendSuccessResponseData([
            'user' => User::with('information')->where('id',auth()->user()->id)->first()
        ]);
    }
}
