<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\TokenQueue;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()->latest();

        if ($request->filled('service')) {
            $query->where('service_name', 'like', '%' . $request->service . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->paginate(15);
        $services = Service::all();

        return view('admin.appointments.index', compact('appointments', 'services'));
    }

    public function create()
    {
        $services = Service::all();
        $doctors = Doctor::where('is_active', true)->get();
        return view('admin.appointments.create', compact('services', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'service_name' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'slot' => 'required|string',
            'patient_phone' => 'nullable|string',
            'patient_age' => 'nullable|string',
            'patient_gender' => 'required|string',
            'fee' => 'nullable|numeric',
        ]);

        $token = 'TK-' . rand(1000, 9999);

        $appointment = Appointment::create([
            'token_number' => $token,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_age' => $request->patient_age,
            'patient_gender' => $request->patient_gender,
            'service_name' => $request->service_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'slot' => $request->slot,
            'status' => 'Waiting',
            'fee' => $request->fee ?? 1000,
        ]);

        // Add to queue
        TokenQueue::create([
            'token_number' => $token,
            'patient_name' => $request->patient_name,
            'phone' => $request->patient_phone,
            'service' => explode('&', $request->service_name)[0],
            'queue_time' => now()->format('h:i A'),
            'status' => 'Waiting',
        ]);

        return redirect()->route('admin.appointments.index')->with('success', "Appointment created with Token {$token}");
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|string']);
        $appointment->update(['status' => $request->status]);

        // Sync with queue
        if ($appointment->token_number) {
            TokenQueue::where('token_number', $appointment->token_number)
                ->update(['status' => $request->status]);
        }

        return back()->with('success', "Appointment status updated to {$request->status}");
    }

    public function printSlip(Appointment $appointment)
    {
        return view('admin.appointments.slip', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->token_number) {
            TokenQueue::where('token_number', $appointment->token_number)->delete();
        }
        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }
}
