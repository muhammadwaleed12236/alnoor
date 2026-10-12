@extends('layouts.admin')

@section('title', 'Diagnostics')
@section('page_title', 'Clinical Diagnostic Reports (Lab / USG / ECG)')

@section('content')
  <div class="content-box">
    <div class="content-box-header">
      <div style="display: flex; gap: 0.5rem; align-items: center;">
        <h3><i class="fa-solid fa-file-waveform" style="color: var(--primary);"></i> Diagnostic Test Reports</h3>
        <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
          Total: {{ $reports->total() }}
        </span>
      </div>

      <a href="{{ route('admin.diagnostics.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus"></i> Enter New Diagnostic Report
      </a>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.diagnostics.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem; background: #f8fafc; padding: 0.85rem; border-radius: 8px;">
      <input type="text" name="search" class="form-control" style="max-width: 260px;" placeholder="Search Patient, Report ID, or Test..." value="{{ request('search') }}">
      
      <select name="category" class="form-control" style="max-width: 200px;">
        <option value="">All Categories</option>
        <option value="Laboratory Testing" {{ request('category') == 'Laboratory Testing' ? 'selected' : '' }}>Laboratory Testing</option>
        <option value="Ultrasound Services" {{ request('category') == 'Ultrasound Services' ? 'selected' : '' }}>Ultrasound Services</option>
        <option value="ECG Services" {{ request('category') == 'ECG Services' ? 'selected' : '' }}>ECG Services</option>
      </select>

      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-magnifying-glass"></i> Search
      </button>
      <a href="{{ route('admin.diagnostics.index') }}" class="btn btn-outline btn-sm">Reset</a>
    </form>

    <div style="overflow-x: auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Report ID</th>
            <th>Patient Details</th>
            <th>Department</th>
            <th>Test Investigation</th>
            <th>Report Date</th>
            <th>Consultant In-Charge</th>
            <th>Parameters</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $rep)
            <tr>
              <td>
                <strong style="color: var(--primary);">{{ $rep->report_id }}</strong>
                <div style="font-size: 0.7rem; color: var(--gray-500);">MRN: {{ $rep->mrn }}</div>
              </td>
              <td>
                <strong>{{ $rep->patient_name }}</strong>
                <div style="font-size: 0.72rem; color: var(--gray-500);">
                  {{ $rep->age ?? '-' }} &bull; {{ $rep->gender ?? '-' }}
                </div>
              </td>
              <td><span class="dept-tag">{{ $rep->category }}</span></td>
              <td><strong>{{ $rep->test_name }}</strong></td>
              <td>{{ date('d-M-Y', strtotime($rep->report_date)) }}</td>
              <td><span style="font-size: 0.82rem; color: var(--dark);">{{ $rep->consultant }}</span></td>
              <td>
                <span class="badge" style="background: #f1f5f9; color: var(--gray-700); font-size: 0.75rem; padding: 2px 7px; border-radius: 4px;">
                  {{ $rep->items->count() }} parameters
                </span>
              </td>
              <td>
                <div style="display: flex; gap: 0.35rem;">
                  <a href="{{ route('admin.diagnostics.show', $rep) }}" class="btn btn-sm btn-primary" style="padding: 2px 8px; font-size: 0.75rem;" title="View and Print Report">
                    <i class="fa-solid fa-print"></i> Report
                  </a>
                  <form action="{{ route('admin.diagnostics.destroy', $rep) }}" method="POST" onsubmit="return confirm('Delete this diagnostic report?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline" style="padding: 2px 8px; color: var(--danger); border-color: var(--danger);" title="Delete">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align: center; color: var(--gray-500); padding: 2rem;">No diagnostic reports found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top: 1.25rem;">
      {{ $reports->links() }}
    </div>
  </div>
@endsection
