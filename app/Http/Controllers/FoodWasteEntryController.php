<?php

namespace App\Http\Controllers;

use App\Models\FoodWasteEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FoodWasteEntryController extends Controller
{
    // List all food waste entries
    public function index()
    {
        // Fetch all food waste entries, possibly filtered by employee or hospital
        $entries = FoodWasteEntry::with(['foodItem', 'employee', 'hospital'])->get();
        return response()->json($entries, 200);
    }

    // Store a new food waste entry
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'food_item_id' => 'required|exists:food_items,id',
            'quantity' => 'required|numeric|min:0',
            'date_of_entry' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the food waste entry
        $entry = FoodWasteEntry::create([
            'hospital_id' => Auth::user()->hospital_id, // Use the authenticated employee's hospital
            'employee_id' => Auth::id(),                // Use the authenticated employee's ID
            'food_item_id' => $request->food_item_id,
            'quantity' => $request->quantity,
            'date_of_entry' => $request->date_of_entry,
        ]);

        return response()->json(['message' => 'Food waste entry created successfully', 'entry' => $entry], 201);
    }

    // Show a single food waste entry
    public function show($id)
    {
        $entry = FoodWasteEntry::with(['foodItem', 'employee', 'hospital'])->find($id);

        if (!$entry) {
            return response()->json(['message' => 'Food waste entry not found'], 404);
        }

        return response()->json($entry, 200);
    }

    // Update a food waste entry
    public function update(Request $request, $id)
    {
        $entry = FoodWasteEntry::find($id);

        if (!$entry) {
            return response()->json(['message' => 'Food waste entry not found'], 404);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'food_item_id' => 'sometimes|required|exists:food_items,id',
            'quantity' => 'sometimes|required|numeric|min:0',
            'date_of_entry' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the food waste entry details
        $entry->update([
            'food_item_id' => $request->food_item_id ?? $entry->food_item_id,
            'quantity' => $request->quantity ?? $entry->quantity,
            'date_of_entry' => $request->date_of_entry ?? $entry->date_of_entry,
        ]);

        return response()->json(['message' => 'Food waste entry updated successfully', 'entry' => $entry], 200);
    }

    // Delete a food waste entry
    public function destroy($id)
    {
        $entry = FoodWasteEntry::find($id);

        if (!$entry) {
            return response()->json(['message' => 'Food waste entry not found'], 404);
        }

        // Delete the entry
        $entry->delete();

        return response()->json(['message' => 'Food waste entry deleted successfully'], 200);
    }
}
