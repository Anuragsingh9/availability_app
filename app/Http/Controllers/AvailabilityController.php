<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Category;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Method to show create availability form
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.availability.create', compact('categories'));
    }

    /**
     * Method to store availability
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'interval' => 'required|integer|min:1',
        ]);

        Availability::create($request->all());

        return redirect()->route('admin.availabilities.index')->with('success', 'Availability added successfully.');
    }

    /**
     * Method to show all availabilities
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->input('category_id');

        $availabilities = Availability::when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })->get();

        return view('admin.availability.index', compact('availabilities', 'categories', 'categoryId'));
    }

    /**
     * Method to show edit availability form
     */
    public function edit($id)
    {
        $availability = Availability::findOrFail($id);
        $categories = Category::all();
        return view('admin.availability.edit', compact('availability', 'categories'));
    }

    /**
     * Method to update an availability
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'interval' => 'required|integer|min:1',
        ]);

        $availability = Availability::findOrFail($id);
        $availability->update($request->all());

        return redirect()->route('admin.availabilities.index')->with('success', 'Availability updated successfully.');
    }

    /**
     * Method to delete an availability
     */
    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return redirect()->route('admin.availabilities.index')->with('success', 'Availability deleted successfully.');
    }
}