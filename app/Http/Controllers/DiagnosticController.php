<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosticReport;
use App\Models\ReportItem;
use App\Models\Patient;

class DiagnosticController extends Controller
{
    public function index(Request $request)
    {
        $query = DiagnosticReport::with('items')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($sq) use ($q) {
                $sq->where('patient_name', 'like', "%{$q}%")
                   ->orWhere('report_id', 'like', "%{$q}%")
                   ->orWhere('test_name', 'like', "%{$q}%");
            });
        }

        $reports = $query->paginate(15);
        return view('admin.diagnostics.index', compact('reports'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('admin.diagnostics.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'category' => 'required|string',
            'test_name' => 'required|string',
            'report_date' => 'required|date',
            'consultant' => 'nullable|string',
            'params' => 'nullable|array',
        ]);

        $reportId = 'REP-' . rand(100, 999);

        $report = DiagnosticReport::create([
            'report_id' => $reportId,
            'token_number' => $request->token_number ?? ('TK-' . rand(1000, 9999)),
            'mrn' => $request->mrn ?? ('MR-' . rand(1000, 9999)),
            'patient_name' => $request->patient_name,
            'age' => $request->age ?? '25 Yrs',
            'gender' => $request->gender ?? 'Female',
            'doctor' => $request->doctor ?? 'Consultant Gynecologist',
            'category' => $request->category,
            'test_name' => $request->test_name,
            'report_date' => $request->report_date,
            'status' => 'Ready',
            'impression' => $request->impression ?? 'All observed clinical parameters verified within acceptable clinical references.',
            'consultant' => $request->consultant ?? 'Dr. In-Charge',
        ]);

        if ($request->has('params') && is_array($request->params)) {
            foreach ($request->params as $p) {
                if (!empty($p['param']) && !empty($p['value'])) {
                    $report->items()->create([
                        'param' => $p['param'],
                        'value' => $p['value'],
                        'normal_range' => $p['normal_range'] ?? 'Standard Range',
                    ]);
                }
            }
        }

        return redirect()->route('admin.diagnostics.show', $report)->with('success', "Report {$reportId} created successfully!");
    }

    public function show(DiagnosticReport $report)
    {
        $report->load('items');
        return view('admin.diagnostics.show', compact('report'));
    }

    public function destroy(DiagnosticReport $report)
    {
        $report->delete();
        return back()->with('success', 'Diagnostic report deleted.');
    }
}
