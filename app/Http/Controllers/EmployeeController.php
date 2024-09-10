<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // List all employees of the hospital or all employees if admin
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // If the user is an admin, show all employees
        if ($user->role === 'admin') {
            $employees = User::where('role', 'employee')->get();
        } 
        // If the user is a hospital owner, show only employees from their hospital
        elseif ($user->role === 'hospital_owner') {
            $employees = User::where('hospital_id', $user->hospital_id)->where('role', 'employee')->get();
        } 
        else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($employees, 200);
    }

    // Store a new employee (hospital owner or admin adds a new employee)
    public function store(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Ensure the user is a hospital owner or admin
        if ($user->role !== 'hospital_owner' && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'hospital_id' => 'required_if:role,admin|exists:hospitals,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Determine which hospital to assign the employee to
        $hospitalId = ($user->role === 'hospital_owner') ? $user->hospital_id : $request->hospital_id;

        // Create the new employee and assign the hospital_id
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'hospital_id' => $hospitalId,  // Assign the appropriate hospital ID
        ]);

        return response()->json(['message' => 'Employee created successfully', 'employee' => $employee], 201);
    }

    // Show a single employee (details of an employee)
    public function show($id)
    {
        $user = Auth::user();

        // Fetch the employee
        $employee = User::where('role', 'employee')->find($id);

        // Check if the user is authorized to view the employee
        if ($user->role === 'admin' || ($user->role === 'hospital_owner' && $employee->hospital_id === $user->hospital_id)) {
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            return response()->json($employee, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Update an employee's information
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Find the employee
        $employee = User::where('role', 'employee')->find($id);

        // Ensure the user is authorized to update the employee
        if ($user->role === 'admin' || ($user->role === 'hospital_owner' && $employee->hospital_id === $user->hospital_id)) {
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Update the employee's data
            $employee->update([
                'name' => $request->name ?? $employee->name,
                'email' => $request->email ?? $employee->email,
                'password' => isset($request->password) ? Hash::make($request->password) : $employee->password,
            ]);

            return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Delete an employee
    public function destroy($id)
    {
        $user = Auth::user();

        // Find the employee
        $employee = User::where('role', 'employee')->find($id);

        // Ensure the user is authorized to delete the employee
        if ($user->role === 'admin' || ($user->role === 'hospital_owner' && $employee->hospital_id === $user->hospital_id)) {
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            // Delete the employee
            $employee->delete();

            return response()->json(['message' => 'Employee deleted successfully'], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
