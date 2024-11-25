<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroceryListController extends Controller
{
    public function index()
    {
        // remember that compact() take the name of variable as strings
        // create an associative arrray, KEYS are the var names, VALUES are variable values
        $user = Auth::user();
        $groceryItems = $user->groceryLists()->latest()->paginate(10);

        return view('grocery.index', compact('groceryItems'));
    }

    public function create()
    {
        return view('grocery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'estimated_price' => 'nullable|numeric|min:0',
            'purchased' => 'boolean',
        ]);

        $user = Auth::user();
        $user->groceryLists()->create($validated);

        return view('grocery.index')->with('success', 'Grocery item added okay');

    }
}
