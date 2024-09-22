<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    // Fetch all hospitals with their owners
    public function index()
    {
        $hospitals = Hospital::with('owner')->get();
        return response()->json($hospitals);
    }

    // Create a new hospital and associated owner
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'hospital_phone' => 'required|string|max:50',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // Create the hospital owner (user)
            $user = User::create([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'password' => Hash::make($request->owner_password),
                'role' => 'hospital', // Set the user role as hospital owner
            ]);

            // Create the hospital and associate it with the owner
            $hospital = Hospital::create([
                'name' => $request->hospital_name,
                'address' => $request->hospital_address,
                'phone' => $request->hospital_phone,
                'owner_id' => $user->id, // Link the hospital with the created owner
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Hospital and owner created successfully!',
                'hospital' => $hospital,
                'owner' => $user,
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred while creating the hospital.'], 500);
        }
    }

    // Show details of a specific hospital by ID
    public function show($id)
    {
        $hospital = Hospital::with('owner')->findOrFail($id);
        return response()->json($hospital);
    }

    // Update a hospital and the associated owner
    public function update(Request $request, $id)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'hospital_phone' => 'required|string|max:50',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'owner_password' => 'nullable|string|min:6|confirmed',
        ]);

        $hospital = Hospital::findOrFail($id);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($hospital->owner_id);
            $user->name = $request->owner_name;
            $user->email = $request->owner_email;

            if ($request->filled('owner_password')) {
                $user->password = Hash::make($request->owner_password);
            }

            $user->save();

            $hospital->update([
                'name' => $request->hospital_name,
                'address' => $request->hospital_address,
                'phone' => $request->hospital_phone,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Hospital and owner updated successfully!',
                'hospital' => $hospital,
                'owner' => $user,
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred while updating the hospital.'], 500);
        }
    }

    // Delete a hospital and its associated owner
    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($hospital->owner_id);
            $user->delete();
            $hospital->delete();

            DB::commit();

            return response()->json(['message' => 'Hospital and owner deleted successfully'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred while deleting the hospital.'], 500);
        }
    }
}
