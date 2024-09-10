<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    // List all items
    public function index()
    {
        $items = Item::all();
        return response()->json($items, 200);
    }

    // Store a new item
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the item
        $item = Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'created_by' => Auth::id(),  // Store the employee ID who created the item
        ]);

        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    // Show a single item
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item, 200);
    }

    // Update an item
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the item details
        $item->update([
            'name' => $request->name ?? $item->name,
            'category_id' => $request->category_id ?? $item->category_id,
            'description' => $request->description ?? $item->description,
        ]);

        return response()->json(['message' => 'Item updated successfully', 'item' => $item], 200);
    }

    // Delete an item
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Delete the item
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully'], 200);
    }
}
