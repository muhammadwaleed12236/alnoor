@extends('layouts.admin')

@section('title', 'Doctors & Specialists')
@section('page_title', 'Doctors & OPD Roster Management')

@section('content')
  <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Add Doctor Card -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-user-doctor" style="color: var(--primary);"></i> Add Doctor / Specialist</h3>
      </div>

      <form action="{{ route('admin.doctors.store') }}" method="POST" class="quick-form">
        @csrf

        <div class="form-group">
          <label for="name">Doctor Full Name *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Dr. Ayesha Fatima" required>
        </div>

        <div class="form-group">
          <label for="qualification">Qualifications *</label>
          <input type="text" name="qualification" id="qualification" class="form-control" placeholder="MBBS, FCPS (Gynecology)" required>
        </div>

        <div class="form-group">
          <label for="role">Clinical Role / Specialty *</label>
          <input type="text" name="role" id="role" class="form-control" placeholder="Senior Consultant Gynecologist" required>
        </div>

        <div class="form-row-2col">
          <div class="form-group">
            <label for="experience">Experience</label>
            <input type="text" name="experience" id="experience" class="form-control" placeholder="10+ Years" required>
          </div>
          <div class="form-group">
            <label for="fee">Consultation Fee</label>
            <input type="text" name="fee" id="fee" class="form-control" placeholder="Rs. 1,500">
          </div>
        </div>

        <div class="form-group">
          <label for="timings">OPD Timings *</label>
          <input type="text" name="timings" id="timings" class="form-control" placeholder="Mon - Fri: 10:00 AM - 02:00 PM" required>
        </div>

        <div class="form-group">
          <label for="avatar">Photo URL (Optional)</label>
          <input type="url" name="avatar" id="avatar" class="form-control" placeholder="https://images.unsplash.com/...">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
          <i class="fa-solid fa-plus"></i> Save Doctor Profile
        </button>
      </form>
    </div>

    <!-- Doctors Table -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-user-nurse" style="color: var(--accent-pink);"></i> Active Specialists & OPD Roster</h3>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Doctor</th>
              <th>Specialty & Experience</th>
              <th>OPD Schedule</th>
              <th>Fee</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($doctors as $doc)
              <tr>
                <td>
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="{{ $doc->avatar }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div>
                      <strong>{{ $doc->name }}</strong>
                      <div style="font-size: 0.72rem; color: var(--primary);">{{ $doc->qualification }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div>{{ $doc->role }}</div>
                  <span style="font-size: 0.72rem; color: var(--gray-500);">{{ $doc->experience }}</span>
                </td>
                <td>
                  <div style="font-size: 0.8rem;"><i class="fa-regular fa-clock"></i> {{ $doc->timings }}</div>
                </td>
                <td><strong>{{ $doc->fee }}</strong></td>
                <td>
                  <form action="{{ route('admin.doctors.toggle', $doc) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="badge-status {{ $doc->is_active ? 'badge-Completed' : 'badge-Cancelled' }}" style="border: none; cursor: pointer;">
                      {{ $doc->is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </form>
                </td>
                <td>
                  <form action="{{ route('admin.doctors.destroy', $doc) }}" method="POST" onsubmit="return confirm('Delete doctor record?')">
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
                <td colspan="6" style="text-align: center; color: var(--gray-500); padding: 1.5rem;">No doctors registered.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 1.25rem;">
        {{ $doctors->links() }}
      </div>
    </div>
  </div>
@endsection
