<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request) {
        $validation = validator($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }
        $user = User::create(array_merge($validation->validated(),['password'=>bcrypt($request->password)]));
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        $validation = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }
        if(! $token = Auth::attempt($validation->validated())) {
            return response()->json(['errors '=> 'invalid email or password'], Response::HTTP_BAD_REQUEST);
        }
        // $user = User::create(array_merge($validation->validated(),['password'=>bcrypt($request->password)]));
        return $this->createNewToken($token);
    }

    public function me() {

        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error'=>'Authentication Failed'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], 401);
        }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], 500);

        }
        return response()->json($user, Response::HTTP_OK);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => auth()->user()
        ]);
    }
}
