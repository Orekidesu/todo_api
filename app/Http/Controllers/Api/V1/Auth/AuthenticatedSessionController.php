<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // $request->session()->regenerate();

        if (!Auth::check()) {
            return response()->json([
                'message' => 'Authentication Failed'
            ], 401);
        }

        $token = $request->user()->createToken('api-token')->plainTextToken;


        return response(
            [
                'user' => $request->user(),
                'token' => $token,
                'message' => "login in successfully",
            ],
            200
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'User is not logged it'
            ], 401);
        }

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'user logged out successfully'
        ], 200);
    }
}