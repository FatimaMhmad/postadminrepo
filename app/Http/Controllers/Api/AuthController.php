<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchOldPassword;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'email'    => 'required|string|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);


        if (!$token)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json(
            [
                'status' => 'success',
                'user' => $user,
                'authorisation' =>
                [
                    'token' => $token,
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'type' => 'bearer',
                ]
            ]
        );

        // if (! $token = auth()->attempt($validator->validated())) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'min:6'
            ]
    );

        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL()* 60 ,
            'type' => 'bearer',
            ]
        ]);

        // $user = User::create(array_merge(
        //             $validator->validated(),
        //             ['password' => Hash::make($request->password) ]
        //            // ['password' => bcrypt($request->password)]
        //         ));

    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);

        // auth()->logout();
        // return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        return response()->json(
            [
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' =>
            [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
            ]
        );

       // return $this->createNewToken(auth()->refresh());
    }

    public function userProfile()
    {
        return response()->json(Auth::user());

        //return response()->json(auth()->user());
    }

    // protected function createNewToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->user()
    //     ]);
    // }

    public function changePassword(Request $request)
    {
        $user=User::query()->findOrFail(auth()->user()->id);

        $validator = Validator::make($request->all(),
            [
                'current_password'      => 'required',
                'password'              => 'confirmed|string|min:6',
                'password_confirmation' => 'min:6'
            ]
        );

        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if(!Hash::check($request->current_password, $user->password)){
            return response("error Old Password Doesn't match!");
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User successfully updated',
            'user' => $user
        ], 201);
    }
}
