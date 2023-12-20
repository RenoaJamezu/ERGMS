<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Customers;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email', Rule::unique('customers')],
            'password' => 'required|min:8',
        ]);

        $customer = Customers::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'customer created successfully',
            'data' => $customer,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $customer = Customers::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'customer not found',
            ], 401);
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'login successful',
            'data' => [
                'customer' => $customer,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'logged out successfully',
        ], 200);
    }
}
