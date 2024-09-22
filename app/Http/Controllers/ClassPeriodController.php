<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use Illuminate\Http\Request;

class ClassPeriodController extends Controller
{

    // Display all class periods
    public function index()
    {
        $classPeriods = ClassPeriod::all();
        return view('class_periods.index', compact('classPeriods'));
    }

    // Show form to create a new class period
    public function create()
    {
        return view('class_periods.create');
    }

    // Store a new class period in the database
    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'monday' => 'nullable|string',
            'tuesday' => 'nullable|string',
            'wednesday' => 'nullable|string',
            'thursday' => 'nullable|string',
            'friday' => 'nullable|string',
        ]);

        ClassPeriod::create($request->all());

        return redirect()->route('class_periods.index')->with('success', 'Class Period created successfully.');
    }

    // Show form to edit an existing class period
    public function edit($id)
    {
        $classPeriod = ClassPeriod::findOrFail($id);
        return view('class_periods.edit', compact('classPeriod'));
    }

    // Update the class period in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'class' => 'required|string',
            'monday' => 'nullable|string',
            'tuesday' => 'nullable|string',
            'wednesday' => 'nullable|string',
            'thursday' => 'nullable|string',
            'friday' => 'nullable|string',
        ]);

        $classPeriod = ClassPeriod::findOrFail($id);
        $classPeriod->update($request->all());

        return redirect()->route('class_periods.index')->with('success', 'Class Period updated successfully.');
    }

    // Delete a class period
    public function destroy($id)
    {
        $classPeriod = ClassPeriod::findOrFail($id);
        $classPeriod->delete();

        return redirect()->route('class_periods.index')->with('success', 'Class Period deleted successfully.');
    }
}

