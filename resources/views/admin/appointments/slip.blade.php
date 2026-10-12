<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Token Slip - {{ $appointment->token_number }}</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      background: #f1f5f9;
      display: grid;
      place-items: center;
      min-height: 100vh;
      padding: 1.5rem;
    }
    .slip-container {
      background: #fff;
      max-width: 440px;
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      padding: 2rem;
    }
  </style>
</head>
<body>

  <div class="slip-container printable-area">
    <div class="token-slip" style="margin-top: 0;">
      <div class="token-slip-header">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">Al-Noor Mother & Child Clinic</h3>
        <p style="font-size: 0.78rem; color: var(--gray-500);">OPD & DIAGNOSTIC APPOINTMENT TOKEN</p>
      </div>

      <div class="token-number-box">
        {{ $appointment->token_number }}
      </div>

      <div class="token-details-grid" style="grid-template-columns: 1fr;">
        <p><strong>Patient Name:</strong> {{ $appointment->patient_name }} ({{ $appointment->patient_age ?? 'Age N/A' }})</p>
        <p><strong>Phone:</strong> {{ $appointment->patient_phone ?? '-' }}</p>
        <p><strong>Service:</strong> {{ $appointment->service_name }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor_name ?? 'Duty Specialist' }}</p>
        <p><strong>Date & Slot:</strong> {{ date('d-M-Y', strtotime($appointment->appointment_date)) }} &bull; {{ $appointment->slot }}</p>
        <p><strong>Fee:</strong> Rs. {{ number_format($appointment->fee ?? 1000) }} ({{ $appointment->status }})</p>
      </div>

      <p style="font-size: 0.75rem; color: var(--gray-500); margin-bottom: 0.5rem;">
        Please present this token at the reception desk 15 minutes before your time slot.
      </p>
    </div>

    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;" class="no-print">
      <button class="btn btn-primary" style="flex: 1;" onclick="window.print()">
        <i class="fa-solid fa-print"></i> Print Slip
      </button>
      <button class="btn btn-outline" style="flex: 1;" onclick="window.close()">
        Close
      </button>
    </div>
  </div>

</body>
</html>
