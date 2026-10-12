@extends('layouts.admin')

@section('title', 'New Appointment')
@section('page_title', 'Schedule Patient Appointment')

@section('content')
  <div class="content-box" style="max-width: 780px; margin: 0 auto;">
    <div class="content-box-header">
      <h3><i class="fa-solid fa-calendar-plus" style="color: var(--primary);"></i> Book New Clinical Appointment</h3>
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline btn-sm">&larr; Back to List</a>
    </div>

    <form action="{{ route('admin.appointments.store') }}" method="POST" class="quick-form">
      @csrf

      <div class="form-group">
        <label for="patient_name">Patient Full Name *</label>
        <input type="text" name="patient_name" id="patient_name" class="form-control" required placeholder="e.g. Fatima Tariq" value="{{ old('patient_name') }}">
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="patient_age">Age</label>
          <input type="text" name="patient_age" id="patient_age" class="form-control" placeholder="e.g. 28 Yrs" value="{{ old('patient_age') }}">
        </div>
        <div class="form-group">
          <label for="patient_gender">Gender *</label>
          <select name="patient_gender" id="patient_gender" class="form-control">
            <option value="Female">Female</option>
            <option value="Male">Male</option>
            <option value="Child">Child</option>
          </select>
        </div>
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="patient_phone">Phone Number</label>
          <input type="tel" name="patient_phone" id="patient_phone" class="form-control" placeholder="0300-1234567" value="{{ old('patient_phone') }}">
        </div>
        <div class="form-group">
          <label for="fee">Consultation / Service Fee (Rs.)</label>
          <input type="number" name="fee" id="fee" class="form-control" placeholder="1000" value="{{ old('fee', 1000) }}">
        </div>
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="service_name">Clinical Service *</label>
          <select name="service_name" id="service_name" class="form-control" required>
            @foreach($services as $srv)
              <option value="{{ $srv->title }}">{{ $srv->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="doctor_name">Attending Doctor / Specialist</label>
          <select name="doctor_name" id="doctor_name" class="form-control">
            <option value="">Any Duty Doctor</option>
            @foreach($doctors as $doc)
              <option value="{{ $doc->name }}">{{ $doc->name }} ({{ $doc->role }})</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="appointment_date">Appointment Date *</label>
          <input type="date" name="appointment_date" id="appointment_date" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="slot">Shift / Time Slot *</label>
          <select name="slot" id="slot" class="form-control" required>
            <option value="Morning (10:00 AM - 01:00 PM)">Morning (10:00 AM - 01:00 PM)</option>
            <option value="Evening (05:00 PM - 09:00 PM)">Evening (05:00 PM - 09:00 PM)</option>
            <option value="Emergency (Immediate)">Emergency (Immediate)</option>
          </select>
        </div>
      </div>

      <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
        <button type="submit" class="btn btn-primary" style="flex: 1;">
          <i class="fa-solid fa-circle-check"></i> Save Appointment & Generate Token
        </button>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
@endsection
