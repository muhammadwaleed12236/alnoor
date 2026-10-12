<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TokenQueue;
use App\Models\Patient;
use App\Models\DiagnosticReport;
use App\Models\Doctor;
use App\Models\PharmacyItem;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
            'total_appointments' => Appointment::count(),
            'waiting_queue' => TokenQueue::where('status', 'Waiting')->count(),
            'total_patients' => Patient::count(),
            'diagnostic_reports' => DiagnosticReport::count(),
            'active_doctors' => Doctor::where('is_active', true)->count(),
            'pharmacy_medicines' => PharmacyItem::count(),
            'low_stock_medicines' => PharmacyItem::where('stock_qty', '<', 30)->count(),
        ];

        $recentAppointments = Appointment::latest()->take(6)->get();
        $liveQueue = TokenQueue::latest()->take(8)->get();
        $recentReports = DiagnosticReport::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'liveQueue', 'recentReports'));
    }
}
