<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Customers;

class AuthController extends Controller
{

  public function registerCustomer(Request $request)
  {
        $request->validate([
            'email' => ['required', 'email', Rule::unique('customers')],
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);

        $customer = Customers::create([
            'email' => $request->email,
            'hashed_password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
        ]);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Customer created successfully',
                'data' => $customer,
            ],
            201
        );
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $customer = Customers::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->hashed_password)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid email or password. Please try again.',
                ],
                401
            );
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'message' => 'Login successful',
                'data' => [
                    'customer' => $customer,
                    'token' => $token,
                ],
            ],
            200
        );
    }

    public function logoutCustomer(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logged out successfully',
            ],
            200
        );
    }

}
