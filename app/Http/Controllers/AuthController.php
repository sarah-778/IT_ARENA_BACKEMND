<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // LOGIN
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad credentials'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    // UPDATE PROFILE (NEW)
    public function updateProfile(Request $request) {
        $user = $request->user();

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            // unique:users,email,[ID] ignores the current user's email during the check
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);

        return response([
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }

    // LOGOUT (NEW)
    public function logout(Request $request) {
        // This deletes the token currently being used for the request
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Logged out successfully'
        ], 200);
    }
}