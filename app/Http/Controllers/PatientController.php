<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('appointments')->latest();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('mr_number', 'like', "%{$q}%")
                   ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        $patients = $query->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'age' => 'nullable|string',
            'gender' => 'required|string',
            'address' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);

        $mrn = 'MR-' . rand(1000, 9999);

        Patient::create([
            'mr_number' => $mrn,
            'name' => $request->name,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'medical_notes' => $request->medical_notes,
        ]);

        return back()->with('success', "Patient registered with MR Number: {$mrn}");
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient record deleted.');
    }
}
