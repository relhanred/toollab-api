<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return School::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'access' => 'required|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('school_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $school = School::create($validatedData);

        return response()->json($school, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        return $school;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'sometimes|required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'access' => 'sometimes|required|boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }

            $logoPath = $request->file('logo')->store('school_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $school->update($validatedData);

        return response()->json($school, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        // Delete the logo file if it exists
        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();

        return response()->json(null, 204);
    }

    public function getAllFamiliesInSchool(School $school) {
        // Implementation as needed
    }
}
