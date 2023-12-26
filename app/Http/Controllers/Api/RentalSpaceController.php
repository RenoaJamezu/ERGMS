<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalSpaces;
use Illuminate\Support\Facades\Auth;

class RentalSpaceController extends Controller
{
    public function addRentalSpaces(Request $request, RentalSpaces $rentalSpace)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'recommended_business' => 'required',
            'location' => 'required',
            'monthly_price' => 'required|numeric',
        ]);

        // Get the authenticated employee
        $authenticatedEmployee = auth()->user();

        if (!$authenticatedEmployee) {
          return response()->json([
              'status' => 'Error',
              'message' => 'Unauthorized',
          ], 401);
          }

        // Create a new rental space associated with the authenticated employee
        $newRentalSpace = $authenticatedEmployee->rentalSpaces()->create([
            'name' => $validatedData['name'],
            'recommended_business' => $validatedData['recommended_business'],
            'location' => $validatedData['location'],
            'monthly_price' => $validatedData['monthly_price'],
            'date_created' => now(),
        ]);

        // Return a response or redirect as needed
        return response()->json([
            'status' => 'Success',
            'message' => 'Rental Space Added Successfully',
            'data' => $newRentalSpace,
        ], 201);
    }

    public function getRentalSpaces()
    {
        try {
            // Get all rental spaces
            $rentalSpaces = RentalSpaces::all();

            return response()->json([
                'status' => 'Success',
                'message' => 'Rental Spaces retrieved successfully',
                'data' => $rentalSpaces,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Unable to retrieve rental spaces',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
