<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\ReceptionistResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserRoleService;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // register a new user method
    public function register(RegisterRequest $request){
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        // UserRoleService::createUserByRole($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        // $cookie = cookie('token', $token, 60 * 24); // 1 day

        // return response()->json([
        //     'user' => new UserResource($user),
        // ])->withCookie($cookie);
        return $this->respondWithTokenAndRole($user, $token);

    }

    //login a user method
    public function login (LoginRequest $request){
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'] , $user->password)){
            return response()->json([
                'message' => 'Email or password is incorrect!'
            ], 401);
        }

         // Kiểm tra trạng thái tài khoản
        if ($user->status === 0) {
            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa.'
            ], 403); // 403 Forbidden
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // $cookie = cookie('token', $token, 60 * 24); // 1 day

        // return response()->json([
        //     'user' => new UserResource($user),
        // ])->withCookie($cookie);   
        return $this->respondWithTokenAndRole($user, $token);
    }

    // logout a user method
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        $cookie = cookie()->forget('token');
        // $cookie = cookie('token', '', -1); // delete the cookie

        return response()->json([
            'message' => 'Logged out successfully!'
        ])->withCookie($cookie);
    }

    // get the authenticated user method
    // public function user(Request $request) {
    //     return new UserResource($request->user());
    // }

    // get the authenticated user method
    public function user(Request $request) {
        return $this->respondWithRole($request->user());
    }

    private function respondWithRole(User $user) {
        return UserRoleService::getResourceByRole($user);
    }
    private function respondWithTokenAndRole(User $user, string $token = null) {
        $resource = $this->respondWithRole($user); // JsonResource

        if ($token) {
            $cookie = cookie('token', $token, 60 * 24); // 1 day
             return response($resource)->withCookie($cookie);
        }

        return response($resource);
    }
}
