<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\Employees;

class AuthController extends Controller
{
    // Customers
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email', Rule::unique('customers')],
            'password' => 'required|min:8',
        ]);

        $customer = Customers::create([
            'first_name' => $request->input(first_name),
            'last_name' => $request->input(last_name),
            'address' => $request->input(address),
            'email' => $request->input(email),
            'password' => Hash::make($request->input(password)),
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Customer Created Successfully.',
            'data' => $customer,
        ], 200);
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $customer = Customers::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Customer Not Found.',
            ], 404);
        }

        if (!Hash::check($request->password, $customer->password)) {
            return response()->json([
              'status' => 'Error',
              'message' => 'Invalid Password, Please Try Again.',
            ], 422);
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'login Successful.',
            'data' => [
                'customer' => $customer,
                'token' => $token,
            ],
        ], 200);
    }

    public function logoutCustomer(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Logged Out Successfully.',
        ], 204);
    }


    // Employee
    public function registerEmployee(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('employees')],
            'password' => 'required|min:8',
        ]);

        $employee = Employees::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Employee Created Successfully.',
            'data' => $employee,
        ], 200);
    }

    public function loginEmployee(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $employee = Employees::where('email', $request->email)->first();

        if (!$employee) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Employee Not Found.',
            ], 404);
        }

        if (!Hash::check($request->password, $employee->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Password, Please Try Again.',
            ], 422);
        }

        $token = $employee->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Successful.',
            'data' => [
                'employee' => $employee,
                'token' => $token,
            ],
        ], 200);
    }

    public function logoutEmployee(Request $request)
    {
      $request->user()->currentAccessToken()->delete();

      return response()->json([
          'status' => 'Success',
          'message' => 'Logged Out Successfully.',
      ], 201);
    }
}
