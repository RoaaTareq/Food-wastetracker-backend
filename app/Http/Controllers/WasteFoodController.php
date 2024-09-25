<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteFood;
use App\Models\Employee;
use App\Models\Category;

class WasteFoodController extends Controller
{
    /**
     * Display a listing of all waste food records for a specific hospital.
     */
    public function index($hospital_id)
    {
        $wasteFoods = WasteFood::where('hospital_id', $hospital_id)->with('category', 'employee')->get();
        return response()->json($wasteFoods);
    }

    /**
     * Store a newly created waste food record in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'item' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
            'note' => 'nullable|string',
            'time' => 'required|date',
            'meal' => 'required|in:Breakfast,Lunch,Dinner,Snack',
            'employee_id' => 'required|exists:employees,id',
            'hospital_id' => 'required|exists:hospitals,id'
        ]);

        // Create a new waste food entry
        $wasteFood = WasteFood::create([
            'item' => $request->item,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'note' => $request->note,
            'time' => $request->time,
            'meal' => $request->meal,
            'employee_id' => $request->employee_id,
            'hospital_id' => $request->hospital_id,
        ]);

        return response()->json([
            'message' => 'Waste food record created successfully',
            'wasteFood' => $wasteFood
        ], 201);
    }

    /**
     * Display the specified waste food record.
     */
    public function show($id)
    {
        $wasteFood = WasteFood::with('category', 'employee')->find($id);

        if (!$wasteFood) {
            return response()->json(['error' => 'Waste food record not found'], 404);
        }

        return response()->json($wasteFood);
    }

    /**
     * Update the specified waste food record in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'item' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
            'note' => 'nullable|string',
            'time' => 'required|date',
            'meal' => 'required|in:Breakfast,Lunch,Dinner,Snack'
        ]);

        // Find the waste food record
        $wasteFood = WasteFood::find($id);
        if (!$wasteFood) {
            return response()->json(['error' => 'Waste food record not found'], 404);
        }

        // Update the waste food record
        $wasteFood->update($request->all());

        return response()->json([
            'message' => 'Waste food record updated successfully',
            'wasteFood' => $wasteFood
        ]);
    }

    /**
     * Remove the specified waste food record from storage.
     */
    public function destroy($id)
    {
        $wasteFood = WasteFood::find($id);

        if (!$wasteFood) {
            return response()->json(['error' => 'Waste food record not found'], 404);
        }

        // Delete the waste food record
        $wasteFood->delete();

        return response()->json([
            'message' => 'Waste food record deleted successfully'
        ]);
    }
}
