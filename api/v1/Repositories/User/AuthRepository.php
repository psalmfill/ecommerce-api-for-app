<?php

namespace Api\v1\Repositories\User;

use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;
use App\Role;
use Illuminate\Http\Response;

class AuthRepository
{

    use Helpers;

    private $user;
    private $role;

    protected $loginAfterSignUp  = true;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }


    public function createUser($data)
    {
        
        $userData = (array) $data->all();

        //check if user exist
        if($this->user->where('email',$userData['email'])->first())
            return response()->json([
                'status' => 'error',
                'message' => 'User with email address already exist'
            ],Response::HTTP_CONFLICT);
            
        $user = new $this->user($userData);
        $user->password = bcrypt($userData['password']);

        if ($user->save()) {

            $role = $this->role->where('name','like','user%')->first();
            $user->roles()->attach($role->id);
            if ($this->loginAfterSignUp)
                return $this->login($data);

            return response()->json([
                'status' => 'success',
                'message' =>  'Account created successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' =>  'Error creating account'
            ], 200);
        }
    }


    public function login(Request $request)
    {
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'token' => $jwt_token,
            'data' => $this->getUserByEmail($request->email)
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }
}
