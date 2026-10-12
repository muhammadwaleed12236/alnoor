@extends('layouts.admin')

@section('title', 'Overview')
@section('page_title', 'Clinic Dashboard Overview')

@section('content')
  <!-- Stats Row -->
  <div class="dashboard-grid-stats">
    <div class="stat-card">
      <div>
        <h3>{{ $stats['today_appointments'] }}</h3>
        <p>Today's Appointments</p>
      </div>
      <div class="stat-icon teal">
        <i class="fa-regular fa-calendar-check"></i>
      </div>
    </div>

    <div class="stat-card">
      <div>
        <h3>{{ $stats['waiting_queue'] }}</h3>
        <p>Active In Waiting Queue</p>
      </div>
      <div class="stat-icon amber">
        <i class="fa-solid fa-users-line"></i>
      </div>
    </div>

    <div class="stat-card">
      <div>
        <h3>{{ $stats['total_patients'] }}</h3>
        <p>Registered Patients (MRNs)</p>
      </div>
      <div class="stat-icon pink">
        <i class="fa-solid fa-hospital-user"></i>
      </div>
    </div>

    <div class="stat-card">
      <div>
        <h3>{{ $stats['diagnostic_reports'] }}</h3>
        <p>Diagnostic Reports Ready</p>
      </div>
      <div class="stat-icon green">
        <i class="fa-solid fa-file-waveform"></i>
      </div>
    </div>
  </div>

  <!-- Quick Actions Bar -->
  <div style="display: flex; gap: 0.85rem; flex-wrap: wrap; margin-bottom: 1.75rem;">
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
      <i class="fa-solid fa-calendar-plus"></i> New Appointment
    </a>
    <a href="{{ route('admin.queue.index') }}" class="btn btn-pink btn-sm">
      <i class="fa-solid fa-id-card-clip"></i> Reception Queue Desk
    </a>
    <a href="{{ route('admin.diagnostics.create') }}" class="btn btn-outline btn-sm">
      <i class="fa-solid fa-file-circle-plus"></i> Enter Diagnostic Test Result
    </a>
    <a href="{{ route('admin.pharmacy.index') }}" class="btn btn-outline btn-sm">
      <i class="fa-solid fa-pills"></i> Check Pharmacy Stock
    </a>
  </div>

  <div style="display: grid; grid-template-columns: 1.35fr 1fr; gap: 1.5rem;">
    <!-- Recent Appointments -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-regular fa-clock" style="color: var(--primary);"></i> Recent Patient Bookings</h3>
        <a href="{{ route('admin.appointments.index') }}" style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">View All &rarr;</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Token</th>
              <th>Patient</th>
              <th>Service</th>
              <th>Date / Slot</th>
              <th>Status</th>
              <th>Slip</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentAppointments as $app)
              <tr>
                <td><strong style="color: var(--primary);">{{ $app->token_number ?? '-' }}</strong></td>
                <td>
                  <strong>{{ $app->patient_name }}</strong>
                  <div style="font-size: 0.72rem; color: var(--gray-500);">{{ $app->patient_phone }}</div>
                </td>
                <td><span style="font-size: 0.8rem;">{{ $app->service_name }}</span></td>
                <td>
                  <div style="font-size: 0.8rem;">{{ date('d-M-Y', strtotime($app->appointment_date)) }}</div>
                  <div style="font-size: 0.72rem; color: var(--gray-500);">{{ $app->slot }}</div>
                </td>
                <td>
                  <span class="badge-status badge-{{ $app->status }}">{{ $app->status }}</span>
                </td>
                <td>
                  <a href="{{ route('admin.appointments.slip', $app) }}" target="_blank" class="btn btn-sm btn-outline" style="padding: 2px 7px; font-size: 0.75rem;">
                    <i class="fa-solid fa-print"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align: center; color: var(--gray-500); padding: 1.5rem;">No appointments found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Live OPD Queue Desk -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-users" style="color: var(--accent-pink);"></i> Live Reception Queue</h3>
        <a href="{{ route('admin.queue.index') }}" style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">Full Desk &rarr;</a>
      </div>

      <div style="display: flex; flex-direction: column; gap: 0.65rem;">
        @forelse($liveQueue as $q)
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0.85rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
              <span style="background: #0f172a; color: #fff; font-size: 0.78rem; font-weight: 800; padding: 3px 6px; border-radius: 4px;">
                {{ $q->token_number }}
              </span>
              <div>
                <strong style="font-size: 0.88rem; color: var(--dark); display: block;">{{ $q->patient_name }}</strong>
                <span style="font-size: 0.75rem; color: var(--gray-500);">{{ $q->service }} &bull; {{ $q->queue_time }}</span>
              </div>
            </div>

            <form action="{{ route('admin.queue.cycle', $q) }}" method="POST">
              @csrf
              @method('PATCH')
              <button type="submit" class="badge-status badge-{{ $q->status }}" style="border: none; cursor: pointer;" title="Click to cycle status">
                {{ $q->status }}
              </button>
            </form>
          </div>
        @empty
          <p style="color: var(--gray-500); text-align: center; padding: 1.5rem;">Queue is empty.</p>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Recent Diagnostic Reports -->
  <div class="content-box" style="margin-top: 1.5rem;">
    <div class="content-box-header">
      <h3><i class="fa-solid fa-microscope" style="color: #059669;"></i> Recent Verified Diagnostic Reports (Lab / USG / ECG)</h3>
      <a href="{{ route('admin.diagnostics.index') }}" style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">View All Reports &rarr;</a>
    </div>

    <div style="overflow-x: auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Report ID</th>
            <th>Patient Name</th>
            <th>Category</th>
            <th>Investigation Test</th>
            <th>Date</th>
            <th>Consultant</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentReports as $rep)
            <tr>
              <td><strong style="color: var(--primary);">{{ $rep->report_id }}</strong></td>
              <td><strong>{{ $rep->patient_name }}</strong> ({{ $rep->age }})</td>
              <td><span class="dept-tag">{{ $rep->category }}</span></td>
              <td>{{ $rep->test_name }}</td>
              <td>{{ date('d-M-Y', strtotime($rep->report_date)) }}</td>
              <td><span style="font-size: 0.8rem; color: var(--gray-700);">{{ $rep->consultant }}</span></td>
              <td>
                <a href="{{ route('admin.diagnostics.show', $rep) }}" class="btn btn-sm btn-primary" style="padding: 2px 9px; font-size: 0.75rem;">
                  <i class="fa-solid fa-file-lines"></i> View & Print
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align: center; color: var(--gray-500); padding: 1.5rem;">No diagnostic reports yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
