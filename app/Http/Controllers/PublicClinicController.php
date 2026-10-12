<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TokenQueue;
use App\Models\DiagnosticReport;

class PublicClinicController extends Controller
{
    /**
     * Display the dynamic clinic home page
     */
    public function index()
    {
        $services = Service::all();
        $doctors = Doctor::where('is_active', true)->get();
        $queue = TokenQueue::latest()->take(10)->get();

        return view('public.index', compact('services', 'doctors', 'queue'));
    }

    /**
     * Handle public patient appointment booking & token generation
     */
    public function bookAppointment(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'service_name' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'slot' => 'required|string',
            'patient_phone' => 'nullable|string|max:50',
            'patient_age' => 'nullable|string|max:50',
            'patient_gender' => 'nullable|string|max:20',
        ]);

        $tokenNum = 'TK-' . rand(1000, 9999);
        $mrn = 'MR-' . rand(1000, 9999);

        // Find or create patient record
        $patient = null;
        if ($request->patient_phone) {
            $patient = Patient::firstWhere('phone', $request->patient_phone);
        }
        if (!$patient) {
            $patient = Patient::create([
                'mr_number' => $mrn,
                'name' => $request->patient_name,
                'age' => $request->patient_age,
                'gender' => $request->patient_gender ?? 'Female',
                'phone' => $request->patient_phone,
            ]);
        } else {
            $mrn = $patient->mr_number;
        }

        // Create appointment
        $appointment = Appointment::create([
            'token_number' => $tokenNum,
            'patient_id' => $patient->id,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_age' => $request->patient_age,
            'patient_gender' => $request->patient_gender ?? 'Female',
            'service_name' => $request->service_name,
            'doctor_name' => $request->doctor_name ?? null,
            'appointment_date' => $request->appointment_date,
            'slot' => $request->slot,
            'status' => 'Waiting',
        ]);

        // Push to Live Reception Queue
        TokenQueue::create([
            'token_number' => $tokenNum,
            'patient_name' => $request->patient_name,
            'phone' => $request->patient_phone,
            'service' => explode('&', $request->service_name)[0],
            'queue_time' => now()->format('h:i A'),
            'status' => 'Waiting',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Appointment booked successfully for {$request->patient_name}!",
            'data' => [
                'token_number' => $tokenNum,
                'mr_number' => $mrn,
                'patient_name' => $request->patient_name,
                'service' => $request->service_name,
                'date' => $request->appointment_date,
                'slot' => $request->slot,
            ]
        ]);
    }

    /**
     * Search diagnostic report by Report ID or Token Number
     */
    public function searchReport(Request $request)
    {
        $id = trim($request->input('report_id', ''));

        $report = DiagnosticReport::with('items')
            ->where('report_id', strtoupper($id))
            ->orWhere('token_number', strtoupper($id))
            ->orWhere('mrn', strtoupper($id))
            ->first();

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => "No medical report found matching '{$id}'. Please check your Report ID or Token.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'report' => [
                'report_id' => $report->report_id,
                'token_number' => $report->token_number,
                'mrn' => $report->mrn,
                'patient_name' => $report->patient_name,
                'age' => $report->age,
                'gender' => $report->gender,
                'doctor' => $report->doctor,
                'category' => $report->category,
                'test_name' => $report->test_name,
                'date' => $report->report_date ? date('d-M-Y', strtotime($report->report_date)) : '',
                'status' => $report->status,
                'impression' => $report->impression,
                'consultant' => $report->consultant,
                'findings' => $report->items->map(function ($item) {
                    return [
                        'param' => $item->param,
                        'value' => $item->value,
                        'normal' => $item->normal_range,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Reception Walk-In Fast Token Generator
     */
    public function quickToken(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $tokenNum = 'TK-' . rand(1000, 9999);

        $queue = TokenQueue::create([
            'token_number' => $tokenNum,
            'patient_name' => $request->patient_name,
            'phone' => $request->phone,
            'service' => $request->service,
            'queue_time' => now()->format('h:i A'),
            'status' => 'Waiting',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Token {$tokenNum} generated successfully!",
            'data' => $queue,
        ]);
    }
}
