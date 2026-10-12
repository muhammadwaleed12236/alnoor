@extends('layouts.admin')

@section('title', 'Patients Registry')
@section('page_title', 'Patients Registry & Medical Records (MRNs)')

@section('content')
  <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Register Patient Card -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-user-plus" style="color: var(--primary);"></i> Register New Patient</h3>
      </div>

      <form action="{{ route('admin.patients.store') }}" method="POST" class="quick-form">
        @csrf

        <div class="form-group">
          <label for="name">Patient Full Name *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Fatima Zahra" required>
        </div>

        <div class="form-row-2col">
          <div class="form-group">
            <label for="age">Age</label>
            <input type="text" name="age" id="age" class="form-control" placeholder="e.g. 26 Yrs">
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
              <option value="Female">Female</option>
              <option value="Male">Male</option>
              <option value="Child">Child</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="phone">Contact Phone</label>
          <input type="tel" name="phone" id="phone" class="form-control" placeholder="0300-XXXXXXX">
        </div>

        <div class="form-group">
          <label for="address">Residential Address</label>
          <input type="text" name="address" id="address" class="form-control" placeholder="City / Area / Street">
        </div>

        <div class="form-group">
          <label for="medical_notes">Clinical / Antenatal Notes</label>
          <textarea name="medical_notes" id="medical_notes" rows="2" class="form-control" placeholder="Allergies, pregnancy trimester, blood group..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
          <i class="fa-solid fa-id-card"></i> Register & Issue MRN
        </button>
      </form>
    </div>

    <!-- Patients Directory -->
    <div class="content-box">
      <div class="content-box-header">
        <div style="display: flex; gap: 0.5rem; align-items: center;">
          <h3><i class="fa-solid fa-hospital-user" style="color: var(--accent-pink);"></i> Registered Patients Directory</h3>
          <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
            Total: {{ $patients->total() }}
          </span>
        </div>
      </div>

      <!-- Search Form -->
      <form method="GET" action="{{ route('admin.patients.index') }}" style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem; background: #f8fafc; padding: 0.75rem; border-radius: 8px;">
        <input type="text" name="search" class="form-control" placeholder="Search by Patient Name, MR Number, or Phone..." value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-outline btn-sm">Reset</a>
      </form>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>MR Number</th>
              <th>Patient</th>
              <th>Age / Gender</th>
              <th>Phone</th>
              <th>Clinical Notes</th>
              <th>Total Visits</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($patients as $pat)
              <tr>
                <td>
                  <strong style="color: var(--primary);">{{ $pat->mr_number }}</strong>
                </td>
                <td>
                  <strong>{{ $pat->name }}</strong>
                  <div style="font-size: 0.72rem; color: var(--gray-500);">{{ $pat->address ?? '-' }}</div>
                </td>
                <td>{{ $pat->age ?? '-' }} / {{ $pat->gender }}</td>
                <td>{{ $pat->phone ?? '-' }}</td>
                <td><span style="font-size: 0.78rem; color: var(--gray-700);">{{ $pat->medical_notes ?? '-' }}</span></td>
                <td>
                  <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 0.75rem; padding: 2px 6px; border-radius: 4px;">
                    {{ $pat->appointments->count() }} visits
                  </span>
                </td>
                <td>
                  <form action="{{ route('admin.patients.destroy', $pat) }}" method="POST" onsubmit="return confirm('Delete patient record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: var(--danger); border: none; background: none; cursor: pointer;">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="text-align: center; color: var(--gray-500); padding: 1.5rem;">No patients found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 1.25rem;">
        {{ $patients->links() }}
      </div>
    </div>
  </div>
@endsection
