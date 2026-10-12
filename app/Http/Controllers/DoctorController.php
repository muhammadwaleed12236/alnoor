<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(15);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'qualification' => 'required|string',
            'role' => 'required|string',
            'experience' => 'required|string',
            'timings' => 'required|string',
            'fee' => 'nullable|string',
            'avatar' => 'nullable|url',
        ]);

        Doctor::create([
            'name' => $request->name,
            'qualification' => $request->qualification,
            'role' => $request->role,
            'experience' => $request->experience,
            'timings' => $request->timings,
            'fee' => $request->fee ?? 'Rs. 1,000',
            'avatar' => $request->avatar ?: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=300&q=80',
            'is_active' => true,
        ]);

        return back()->with('success', 'Doctor profile created.');
    }

    public function toggle(Doctor $doctor)
    {
        $doctor->update(['is_active' => !$doctor->is_active]);
        return back()->with('success', "Doctor status changed to " . ($doctor->is_active ? 'Active' : 'Inactive'));
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'Doctor record deleted.');
    }
}
