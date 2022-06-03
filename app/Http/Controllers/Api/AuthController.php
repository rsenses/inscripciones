<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'advertising' => ['nullable', 'boolean'],
            'data' => ['nullable', 'array'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create(
                [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'tax_id' => strtoupper($request->tax_id),
                'phone' => $request->phone,
                'company' => $request->company,
                'position' => $request->position,
                'data' => $request->data,
                'advertising' => $request->advertising ?: 0,
                'password' => Hash::make($request->password),
            ]
            );
        } else {
            if ($request->data) {
                $user->data = array_unique(array_merge($user->data, $request->data), SORT_REGULAR);
            }
            $user->save();
        }

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::with('registrations')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoking previous tokens
        $user->tokens()->delete();

        return response([
            'user' => $user,
            'access_token' => $user->createToken('Auth Token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            "message" => "User logged out successfully"
        ], 200);
    }
}
