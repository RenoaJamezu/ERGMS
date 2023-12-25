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
            'description' => 'nullable',
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
            'description' => $validatedData['description'],
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
}
