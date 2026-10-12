@extends('layouts.admin')

@section('title', 'Reception Queue Desk')
@section('page_title', 'Live Receptionist OPD Queue Desk')

@section('content')
  <div style="display: grid; grid-template-columns: 1fr 1.8fr; gap: 1.5rem;">
    <!-- Issue Walk-in Token Card -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-id-card-clip" style="color: var(--primary);"></i> Walk-In Token Entry</h3>
      </div>

      <form action="{{ route('admin.queue.store') }}" method="POST" class="quick-form">
        @csrf

        <div class="form-group">
          <label for="patient_name">Patient Name *</label>
          <input type="text" name="patient_name" id="patient_name" class="form-control" placeholder="Patient Full Name" required>
        </div>

        <div class="form-group">
          <label for="service">Department / Service *</label>
          <select name="service" id="service" class="form-control" required>
            <option value="Lady Doctor">Lady Doctor (Gynecology OPD)</option>
            <option value="Maternity Care">Maternity & Delivery Care</option>
            <option value="Ultrasound">Ultrasound (Female Sonologist)</option>
            <option value="Laboratory">Laboratory Testing</option>
            <option value="ECG">ECG Screening</option>
            <option value="Pharmacy">Medical Store (Pharmacy)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="phone">Phone / WhatsApp</label>
          <input type="tel" name="phone" id="phone" class="form-control" placeholder="0300-XXXXXXX">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
          <i class="fa-solid fa-ticket"></i> Issue OPD Token Now
        </button>
      </form>
    </div>

    <!-- Active Queue List -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-users" style="color: var(--accent-pink);"></i> Active OPD Queue Board</h3>
        <span class="badge" style="background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
          <i class="fa-solid fa-circle" style="font-size: 0.5rem; margin-right: 2px;"></i> Live Updates
        </span>
      </div>

      <div style="display: flex; flex-direction: column; gap: 0.75rem;">
        @forelse($queue as $item)
          <div class="queue-item">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
              <span class="queue-token-badge">{{ $item->token_number }}</span>
              <div class="queue-patient-meta">
                <h5>{{ $item->patient_name }}</h5>
                <p>
                  <i class="fa-solid fa-stethoscope"></i> {{ $item->service }} &bull; 
                  <i class="fa-regular fa-clock"></i> {{ $item->queue_time }} 
                  @if($item->phone) &bull; <i class="fa-solid fa-phone"></i> {{ $item->phone }} @endif
                </p>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.65rem;">
              <form action="{{ route('admin.queue.cycle', $item) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="badge-status badge-{{ $item->status }}" style="border: none; cursor: pointer;" title="Click to advance status: Waiting -> In-Consultation -> Completed">
                  {{ $item->status }} &rarr;
                </button>
              </form>

              <form action="{{ route('admin.queue.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove token from queue?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:none; border:none; color: var(--gray-500); cursor:pointer;" title="Remove from queue">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </form>
            </div>
          </div>
        @empty
          <p style="text-align: center; color: var(--gray-500); padding: 2rem;">No tokens in queue right now.</p>
        @endforelse
      </div>

      <div style="margin-top: 1.25rem;">
        {{ $queue->links() }}
      </div>
    </div>
  </div>
@endsection
