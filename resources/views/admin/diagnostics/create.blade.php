@extends('layouts.admin')

@section('title', 'Enter Diagnostic Result')
@section('page_title', 'Create Diagnostic Report (Lab / USG / ECG)')

@section('content')
  <div class="content-box" style="max-width: 860px; margin: 0 auto;">
    <div class="content-box-header">
      <h3><i class="fa-solid fa-file-circle-plus" style="color: var(--primary);"></i> Enter Patient Diagnostic Report</h3>
      <a href="{{ route('admin.diagnostics.index') }}" class="btn btn-outline btn-sm">&larr; Back to Reports</a>
    </div>

    <form action="{{ route('admin.diagnostics.store') }}" method="POST" class="quick-form">
      @csrf

      <div class="form-row-2col">
        <div class="form-group">
          <label for="patient_name">Patient Full Name *</label>
          <input type="text" name="patient_name" id="patient_name" class="form-control" required placeholder="e.g. Fatima Zahra" value="{{ old('patient_name') }}">
        </div>
        <div class="form-group">
          <label for="mrn">MR Number (Medical Record #)</label>
          <input type="text" name="mrn" id="mrn" class="form-control" placeholder="e.g. MR-8842" value="{{ old('mrn') }}">
        </div>
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="age">Age</label>
          <input type="text" name="age" id="age" class="form-control" placeholder="e.g. 27 Yrs" value="{{ old('age') }}">
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

      <div class="form-row-2col">
        <div class="form-group">
          <label for="category">Diagnostic Department *</label>
          <select name="category" id="category" class="form-control" required>
            <option value="Laboratory Testing">Laboratory Testing</option>
            <option value="Ultrasound Services">Ultrasound Services</option>
            <option value="ECG Services">ECG Services</option>
          </select>
        </div>
        <div class="form-group">
          <label for="test_name">Investigation / Test Name *</label>
          <input type="text" name="test_name" id="test_name" class="form-control" required placeholder="e.g. Obstetric Ultrasound / CBC with ESR" value="{{ old('test_name') }}">
        </div>
      </div>

      <div class="form-row-2col">
        <div class="form-group">
          <label for="report_date">Report Date *</label>
          <input type="date" name="report_date" id="report_date" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="consultant">Consultant / Doctor Sign-Off</label>
          <input type="text" name="consultant" id="consultant" class="form-control" placeholder="Dr. Saira Rehman (Radiologist)" value="{{ old('consultant') }}">
        </div>
      </div>

      <!-- Test Finding Parameters Table -->
      <div style="margin: 1.25rem 0; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; background: #f8fafc;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
          <h4 style="font-size: 0.95rem; font-weight: 800; color: var(--dark);">
            <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Investigation Parameters & Observed Values
          </h4>
          <button type="button" class="btn btn-sm btn-outline" onclick="addParamRow()">
            <i class="fa-solid fa-plus"></i> Add Row
          </button>
        </div>

        <table style="width: 100%; border-collapse: collapse;" id="paramsTable">
          <thead>
            <tr style="text-align: left; font-size: 0.8rem; color: var(--gray-500);">
              <th style="padding: 4px;">Parameter Name</th>
              <th style="padding: 4px;">Observed Value</th>
              <th style="padding: 4px;">Normal / Reference Range</th>
              <th style="padding: 4px; width: 40px;"></th>
            </tr>
          </thead>
          <tbody id="paramsBody">
            <tr>
              <td style="padding: 4px;">
                <input type="text" name="params[0][param]" class="form-control" placeholder="e.g. Hemoglobin (Hb)" required>
              </td>
              <td style="padding: 4px;">
                <input type="text" name="params[0][value]" class="form-control" placeholder="e.g. 12.5 g/dL" required>
              </td>
              <td style="padding: 4px;">
                <input type="text" name="params[0][normal_range]" class="form-control" placeholder="e.g. 11.5 - 15.5 g/dL">
              </td>
              <td style="padding: 4px; text-align: center;">
                <button type="button" onclick="this.closest('tr').remove()" style="color: var(--danger); border: none; background: none; cursor: pointer;">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form-group">
        <label for="impression">Clinical Impression / Summary Notes</label>
        <textarea name="impression" id="impression" rows="3" class="form-control" placeholder="Single live intrauterine pregnancy / Normal study..."></textarea>
      </div>

      <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
        <button type="submit" class="btn btn-primary" style="flex: 1;">
          <i class="fa-solid fa-file-check"></i> Save & Generate Verified Medical Report
        </button>
        <a href="{{ route('admin.diagnostics.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  let paramIndex = 1;
  function addParamRow() {
    const tbody = document.getElementById('paramsBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td style="padding: 4px;">
        <input type="text" name="params[${paramIndex}][param]" class="form-control" placeholder="Parameter Name" required>
      </td>
      <td style="padding: 4px;">
        <input type="text" name="params[${paramIndex}][value]" class="form-control" placeholder="Observed Value" required>
      </td>
      <td style="padding: 4px;">
        <input type="text" name="params[${paramIndex}][normal_range]" class="form-control" placeholder="Reference Interval">
      </td>
      <td style="padding: 4px; text-align: center;">
        <button type="button" onclick="this.closest('tr').remove()" style="color: var(--danger); border: none; background: none; cursor: pointer;">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </td>
    `;
    tbody.appendChild(tr);
    paramIndex++;
  }
</script>
@endpush
