@extends('layouts.admin')

@section('title', 'Medical Report - ' . $report->report_id)
@section('page_title', 'Report Preview: ' . $report->report_id)

@section('content')
  <div style="max-width: 860px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;" class="no-print">
      <a href="{{ route('admin.diagnostics.index') }}" class="btn btn-outline btn-sm">&larr; Back to Diagnostics</a>
      <button class="btn btn-primary btn-sm" onclick="window.print()">
        <i class="fa-solid fa-print"></i> Print Official Report (PDF)
      </button>
    </div>

    <div class="printable-area">
      <div class="report-paper">
        <div class="report-clinic-header">
          <div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: var(--primary);">Al-Noor Clinic & Diagnostics</h2>
            <p style="font-size: 0.78rem; color: var(--gray-500);">ISO 9001:2015 Compliant Clinical Laboratory & Diagnostic Centre</p>
            <p style="font-size: 0.78rem; color: var(--gray-500);">Healthcare Plaza, Block C, Main Boulevard | Ph: +92 311 9876543</p>
          </div>
          <div style="text-align: right;">
            <span class="badge" style="background: #dcfce7; color: #166534; font-size: 0.82rem; font-weight: 800; padding: 4px 10px; border-radius: 4px;">VERIFIED REPORT</span>
            <p style="font-size: 0.78rem; color: var(--gray-500); margin-top: 4px;">Date: {{ date('d-M-Y', strtotime($report->report_date)) }}</p>
          </div>
        </div>

        <!-- Patient Information Bar -->
        <div class="report-patient-meta">
          <div><strong>Patient Name:</strong> <span>{{ $report->patient_name }}</span></div>
          <div><strong>Age / Gender:</strong> <span>{{ $report->age ?? '-' }} / {{ $report->gender ?? '-' }}</span></div>
          <div><strong>MR Number:</strong> <span>{{ $report->mrn ?? '-' }}</span></div>
          <div><strong>Referring Doctor:</strong> <span>{{ $report->doctor ?? 'Consultant' }}</span></div>
          <div><strong>Department:</strong> <span>{{ $report->category }}</span></div>
          <div><strong>Report ID:</strong> <span style="font-weight: 800; color: var(--primary);">{{ $report->report_id }}</span></div>
        </div>

        <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--dark); margin-bottom: 0.85rem;">
          {{ $report->test_name }}
        </h3>

        <!-- Parameters Table -->
        <table class="report-table">
          <thead>
            <tr>
              <th>Investigation Parameter</th>
              <th>Observed Value</th>
              <th>Reference / Normal Interval</th>
            </tr>
          </thead>
          <tbody>
            @forelse($report->items as $item)
              <tr>
                <td><strong>{{ $item->param }}</strong></td>
                <td><strong style="color: var(--primary);">{{ $item->value }}</strong></td>
                <td style="color: var(--gray-500); font-size: 0.82rem;">{{ $item->normal_range ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" style="text-align: center; color: var(--gray-500);">No numerical parameters listed.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <!-- Clinical Impression -->
        <div class="report-impression">
          <strong style="color: var(--primary); display: block; margin-bottom: 4px;">
            <i class="fa-solid fa-stethoscope"></i> Clinical Impression / Remarks:
          </strong>
          <p>{{ $report->impression ?? 'Normal findings observed.' }}</p>
        </div>

        <!-- Signatures -->
        <div class="report-signatures">
          <div>
            <p>Medical Technologist</p>
            <strong style="color: var(--dark); font-size: 0.78rem;">Verified by Senior Technologist</strong>
          </div>
          <div style="text-align: right;">
            <p>Consultant In-Charge</p>
            <strong style="color: var(--dark); font-size: 0.88rem;">{{ $report->consultant ?? 'Consultant Pathologist' }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
