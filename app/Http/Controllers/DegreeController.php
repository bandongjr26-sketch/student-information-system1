<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;

class DegreeController extends Controller
{
    // Show all degrees
    public function index()
    {
        $degrees = Degree::orderBy('id', 'desc')->get();

        if (request()->ajax()) {
            return response()->json([
                'degrees' => $degrees
            ]);
        }

        return view('degree', compact('degrees'));
    }

    // Show add degree form
    public function create()
    {
        return view('addDegree');
    }

    // Save new degree
    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree_title' => 'required|string|max:255|unique:degrees,degree_title'
        ]);

        $degree = Degree::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Degree added successfully!',
                'degree' => $degree
            ], 201);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $degree = Degree::findOrFail($id);
        return view('editDegree', compact('degree'));
    }

    // Update degree
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'degree_title' => 'required|string|max:255|unique:degrees,degree_title,' . $id
        ]);

        $degree = Degree::findOrFail($id);
        $degree->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Degree updated successfully!',
                'degree' => $degree
            ]);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree updated successfully!');
    }

    // Delete degree
    public function destroy($id)
    {
        $degree = Degree::findOrFail($id);
        $degree->delete();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Degree deleted successfully!'
            ]);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree deleted successfully!');
    }
}
