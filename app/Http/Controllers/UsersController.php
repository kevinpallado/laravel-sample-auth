<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// models
use App\Models\User;
use App\Models\UserInformation;
// resource
use App\Http\Resources\GeneralResource;
// requests
use App\Http\Requests\Users\AddRequest;
use App\Http\Requests\Users\UpdateRequest;
/**
 * @group User management
 *
 * APIs for managing users
 */
class UsersController extends Controller
{
    /**
     * Display list of users.
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit');

        $query = User::query();
        if($search) {
            $query->where('name', '%'.$search.'%')->orWhere('email', '%'.$search.'%');
        }
        return GeneralResource::collection($query->with('information')->paginate($limit));
    }

    /**
     * Create a new user.
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRequest $request)
    {
        $user = User::create(array_merge(
            ['name' => $request->get('first_name').' '.$request->get('last_name'), 'password' => Hash::make($request->get('password'))], 
            $request->only('email','password','is_suspended','is_login','is_approve','is_agent','is_admin','has_system_access')
        ));

        UserInformation::create(array_merge(['users_id' => $user->id],$request->only(['first_name','last_name','street_address','city','state','postal_code','agent_license_number','contact_number'])));

        return $this->sendSuccessResponse();
    }

    /**
     * Show user logs and information.
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->sendSuccessResponseData($user->load('information')->load('trails'));
    }

    /**
     * Update user information.
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update(array_merge(['name' => $request->get('first_name').' '.$request->get('last_name'), 'password' => Hash::make($request->get('password'))], $request->only('email','is_suspended','is_login','is_approve','is_agent','is_admin','has_system_access')));

        $user->save();

        $userInfo = UserInformation::where('users_id', $user->id)->update($request->only(['first_name','last_name','street_address','city','state','postal_code','agent_license_number','contact_number']));

        return $this->sendSuccessResponse();
    }

    /**
     * Remove user.
     *
     * @header Authorization Bearer {token}
     * 
     * @authenticated
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendSuccessResponse();
    }
}
