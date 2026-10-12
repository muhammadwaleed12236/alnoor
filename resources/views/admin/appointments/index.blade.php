@extends('layouts.admin')

@section('title', 'Appointments')
@section('page_title', 'Patient Appointments & Tokens')

@section('content')
  <div class="content-box">
    <div class="content-box-header">
      <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
        <h3><i class="fa-regular fa-calendar-check" style="color: var(--primary);"></i> All Appointments</h3>
        <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
          Total: {{ $appointments->total() }}
        </span>
      </div>

      <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-plus"></i> Book New Appointment
        </a>
      </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.appointments.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem; background: #f8fafc; padding: 0.85rem; border-radius: 8px;">
      <select name="service" class="form-control" style="max-width: 200px;">
        <option value="">All Services</option>
        @foreach($services as $srv)
          <option value="{{ $srv->title }}" {{ request('service') == $srv->title ? 'selected' : '' }}>{{ $srv->title }}</option>
        @endforeach
      </select>

      <select name="status" class="form-control" style="max-width: 160px;">
        <option value="">All Statuses</option>
        <option value="Waiting" {{ request('status') == 'Waiting' ? 'selected' : '' }}>Waiting</option>
        <option value="In-Consultation" {{ request('status') == 'In-Consultation' ? 'selected' : '' }}>In-Consultation</option>
        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
      </select>

      <input type="date" name="date" class="form-control" style="max-width: 160px;" value="{{ request('date') }}">

      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-filter"></i> Filter
      </button>
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline btn-sm">Reset</a>
    </form>

    <div style="overflow-x: auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Token</th>
            <th>Patient Details</th>
            <th>Service Requested</th>
            <th>Assigned Doctor</th>
            <th>Date & Shift</th>
            <th>Fee</th>
            <th>Status (Click to Change)</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($appointments as $app)
            <tr>
              <td>
                <span style="background: #0f172a; color: #fff; font-weight: 800; padding: 3px 7px; border-radius: 4px; font-size: 0.78rem;">
                  {{ $app->token_number ?? 'N/A' }}
                </span>
              </td>
              <td>
                <strong>{{ $app->patient_name }}</strong>
                <div style="font-size: 0.72rem; color: var(--gray-500);">
                  {{ $app->patient_age ?? 'Age N/A' }} &bull; {{ $app->patient_gender }} &bull; {{ $app->patient_phone }}
                </div>
              </td>
              <td><span style="font-weight: 600; color: var(--primary);">{{ $app->service_name }}</span></td>
              <td><span style="font-size: 0.8rem;">{{ $app->doctor_name ?? 'Any Duty Doctor' }}</span></td>
              <td>
                <div style="font-weight: 600;">{{ date('d-M-Y', strtotime($app->appointment_date)) }}</div>
                <div style="font-size: 0.72rem; color: var(--gray-500);">{{ $app->slot }}</div>
              </td>
              <td><strong>Rs. {{ number_format($app->fee ?? 1000) }}</strong></td>
              <td>
                <form action="{{ route('admin.appointments.status', $app) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('PATCH')
                  <select name="status" onchange="this.form.submit()" class="badge-status badge-{{ $app->status }}" style="border: 1px solid #cbd5e1; outline: none; cursor: pointer;">
                    <option value="Waiting" {{ $app->status == 'Waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="In-Consultation" {{ $app->status == 'In-Consultation' ? 'selected' : '' }}>In-Consultation</option>
                    <option value="Completed" {{ $app->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ $app->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </form>
              </td>
              <td>
                <div style="display: flex; gap: 0.35rem;">
                  <a href="{{ route('admin.appointments.slip', $app) }}" target="_blank" class="btn btn-sm btn-outline" style="padding: 2px 7px;" title="Print Token Slip">
                    <i class="fa-solid fa-print"></i>
                  </a>
                  <form action="{{ route('admin.appointments.destroy', $app) }}" method="POST" onsubmit="return confirm('Delete this appointment record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline" style="padding: 2px 7px; color: var(--danger); border-color: var(--danger);" title="Delete">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align: center; color: var(--gray-500); padding: 2rem;">No appointments found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top: 1.25rem;">
      {{ $appointments->links() }}
    </div>
  </div>
@endsection
