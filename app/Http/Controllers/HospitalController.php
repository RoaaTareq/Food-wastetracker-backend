<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function __construct()
    {
        // Protect all routes to only allow admin users
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            return response()->json(['message' => 'Unauthorized'], 403);
        });
    }

    // Fetch all hospitals
    public function index()
    {
        $hospitals = Hospital::all();
        return response()->json($hospitals, 200);
    }

    // Store a new hospital
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
        ]);

        // Create a new hospital
        $hospital = Hospital::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['message' => 'Hospital created successfully', 'hospital' => $hospital], 201);
    }

    // Show a single hospital
    public function show($id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        return response()->json($hospital, 200);
    }

    // Update a hospital
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
        ]);

        // Find the hospital
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        // Update hospital details
        $hospital->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['message' => 'Hospital updated successfully', 'hospital' => $hospital], 200);
    }

    // Delete a hospital
    public function destroy($id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        $hospital->delete();

        return response()->json(['message' => 'Hospital deleted successfully'], 200);
    }
}
