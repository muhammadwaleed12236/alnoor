@extends('layouts.public')

@section('title', 'Al-Noor Mother & Child Health Clinic | Diagnostic Centre')

@section('content')
  <!-- Hero Section -->
  <section class="hero-section" id="home">
    <div class="container hero-grid">
      <div class="hero-content">
        <div class="hero-badge-tag">
          <i class="fa-solid fa-heart-pulse"></i> Specialized Healthcare for Mother & Family
        </div>
        <h1 class="hero-title">
          Compassionate Care by <br>
          <span class="highlight-pink">Lady Doctors</span> & Advanced <br>
          <span class="highlight-teal">Diagnostic Facilities</span>
        </h1>
        <p class="hero-description">
          Welcome to Al-Noor Clinic. We offer 24/7 dedicated maternity & delivery suites, ultrasound scans by female sonologists, automated clinical lab, digital ECG, and round-the-clock pharmacy under one roof.
        </p>
        <div class="hero-cta-group">
          <button class="btn btn-pink" onclick="openBookingModal('Lady Doctor & Gynae OPD')">
            <i class="fa-solid fa-user-doctor"></i> Book Lady Doctor OPD
          </button>
          <a href="#report-portal" class="btn btn-outline" id="heroCheckReportBtn">
            <i class="fa-solid fa-file-waveform"></i> Track Test Report
          </a>
        </div>
        <div class="hero-highlights">
          <div class="hl-item">
            <h4>24/7</h4>
            <p>Labor Room & Pharmacy</p>
          </div>
          <div class="hl-item">
            <h4>100%</h4>
            <p>Female Gynecologist Team</p>
          </div>
          <div class="hl-item">
            <h4>15 Mins</h4>
            <p>Fast Ultrasound & ECG</p>
          </div>
        </div>
      </div>

      <!-- Quick Action Floating Card -->
      <div class="hero-card">
        <div class="quick-box-title">
          <span>Patient Quick Desk</span>
          <span class="badge" style="font-size: 0.72rem; background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 12px;">Instant Access</span>
        </div>
        <p class="quick-box-subtitle">Select a service to generate your OPD Token or check services instantly.</p>
        
        <div class="quick-action-list">
          <div class="qa-card" onclick="openBookingModal('Lady Doctor & Gynae OPD')">
            <div class="qa-icon pink"><i class="fa-solid fa-user-doctor"></i></div>
            <div class="qa-info">
              <h5>Lady Doctor OPD</h5>
              <p>Consult senior gynecologists & MOs</p>
            </div>
            <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #94a3b8;"></i>
          </div>

          <div class="qa-card" onclick="openBookingModal('Maternity & Delivery Care')">
            <div class="qa-icon pink"><i class="fa-solid fa-baby-carriage"></i></div>
            <div class="qa-info">
              <h5>Maternity & Delivery Care</h5>
              <p>Safe normal delivery & C-section suites</p>
            </div>
            <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #94a3b8;"></i>
          </div>

          <div class="qa-card" onclick="openBookingModal('Ultrasound Services (USG)')">
            <div class="qa-icon"><i class="fa-solid fa-wave-square"></i></div>
            <div class="qa-info">
              <h5>Ultrasound (By Female Sonologist)</h5>
              <p>Pregnancy scan, Doppler & Abdominal</p>
            </div>
            <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #94a3b8;"></i>
          </div>

          <div class="qa-card" onclick="openBookingModal('Laboratory Testing')">
            <div class="qa-icon green"><i class="fa-solid fa-microscope"></i></div>
            <div class="qa-info">
              <h5>Laboratory Testing</h5>
              <p>CBC, Blood Sugar, Hormones & Urine</p>
            </div>
            <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #94a3b8;"></i>
          </div>

          <div class="qa-card" onclick="openBookingModal('ECG Services')">
            <div class="qa-icon"><i class="fa-solid fa-heart-pulse"></i></div>
            <div class="qa-info">
              <h5>Instant 12-Lead ECG</h5>
              <p>Computerized screening with doctor review</p>
            </div>
            <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #94a3b8;"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Services Showcase Section -->
  <section class="section" id="services">
    <div class="container">
      <div class="section-head">
        <span class="section-tag">Clinical Departments</span>
        <h2>Our Specialized Healthcare Services</h2>
        <p>Comprehensive patient-centered healthcare delivered by compassionate professionals with modern clinical diagnostics and 24/7 emergency support.</p>
      </div>

      <div class="services-grid" id="servicesContainer">
        @foreach($services as $srv)
          <article class="service-card {{ in_array($srv->slug, ['maternity-care', 'lady-doctor']) ? 'pink-accent' : '' }}">
            <div class="card-top">
              <div class="card-icon">
                <i class="fa-solid {{ $srv->icon }}"></i>
              </div>
              <span class="service-badge {{ in_array($srv->slug, ['maternity-care', 'lady-doctor']) ? 'pink' : '' }}">
                {{ $srv->badge }}
              </span>
            </div>
            <h3>{{ $srv->title }}</h3>
            <p class="service-desc">{{ $srv->short_desc }}</p>
            
            @if(!empty($srv->features))
              <ul class="feature-list">
                @foreach($srv->features as $f)
                  <li><i class="fa-solid fa-check"></i> {{ $f }}</li>
                @endforeach
              </ul>
            @endif

            <div class="service-meta">
              <div>
                <span style="display:block; font-size:0.72rem; color:var(--gray-500);">Charges / Fee</span>
                <span class="service-price">{{ $srv->starting_fee }}</span>
              </div>
              <button class="btn btn-sm btn-primary" onclick="openBookingModal('{{ $srv->title }}')">
                <i class="fa-solid fa-calendar-plus"></i> Book Now
              </button>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Maternal & Delivery Highlight Feature Banner -->
  <section class="maternity-section">
    <div class="container maternity-feature-grid">
      <div>
        <span class="maternity-tag">Care with Dignity</span>
        <h2 class="maternity-heading">
          Safe Motherhood & 24/7 Delivery Facilities
        </h2>
        <p class="maternity-desc">
          Our maternity department is run entirely by female healthcare providers. We ensure total privacy, sterilized private labor rooms, neonatal support, and affordable delivery care packages designed for maternal peace of mind.
        </p>
        <ul class="maternity-list">
          <li>
            <i class="fa-solid fa-circle-check"></i> Prenatal consultation and high-risk pregnancy management
          </li>
          <li>
            <i class="fa-solid fa-circle-check"></i> Normal delivery suites and emergency operative gynecology
          </li>
          <li>
            <i class="fa-solid fa-circle-check"></i> Dedicated baby warmer and newborn phototherapy backup
          </li>
        </ul>
        <button class="btn btn-pink" onclick="openBookingModal('Maternity & Delivery Care')">
          <i class="fa-solid fa-phone"></i> Inquire Maternity Package
        </button>
      </div>
      <div class="maternity-img-wrap">
        <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80" alt="Maternity Clinic Care">
      </div>
    </div>
  </section>

  <!-- Doctors Roster Section -->
  <section class="section" id="doctors">
    <div class="container">
      <div class="section-head">
        <span class="section-tag">Qualified Medical Staff</span>
        <h2>Meet Our Doctors & Specialists</h2>
        <p>Experienced consultants committed to providing accurate diagnosis, empathetic consultation, and tailored treatment plans.</p>
      </div>

      <div class="doctors-grid" id="doctorsContainer">
        @foreach($doctors as $doc)
          <div class="doctor-card">
            <div class="doctor-img-wrap">
              <img src="{{ $doc->avatar }}" alt="{{ $doc->name }}" loading="lazy">
              <span class="doc-exp-badge">{{ $doc->experience }}</span>
            </div>
            <div class="doctor-info">
              <h4>{{ $doc->name }}</h4>
              <div class="doc-qual">{{ $doc->qualification }}</div>
              <div class="doc-role">{{ $doc->role }}</div>
              <div class="doc-timing">
                <i class="fa-regular fa-clock"></i> {{ $doc->timings }}
              </div>
              <button class="btn btn-sm btn-outline" style="width: 100%;" onclick="openBookingModal('{{ $doc->role }}')">
                Consult Doctor
              </button>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Laboratory & Diagnostics Price Catalog -->
  <section class="section lab-section" id="lab-tests">
    <div class="container">
      <div class="section-head">
        <span class="section-tag">Pathology & Diagnostics</span>
        <h2>Diagnostic Lab & Scan Price Directory</h2>
        <p>Transparent pricing, automated testing, and accurate turnaround times. Search or filter through our available routine and specialized tests.</p>
      </div>

      <div class="lab-panel">
        <div class="lab-filter-bar">
          <div class="search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="labSearchInput" placeholder="Search test name (e.g., CBC, Beta hCG, Ultrasound)...">
          </div>
          <div style="font-size: 0.85rem; color: var(--gray-500);">
            <i class="fa-solid fa-circle-info"></i> All samples are processed in computerized automated analyzers.
          </div>
        </div>

        <div class="lab-table-container">
          <table class="custom-table" id="labTestsTable">
            <thead>
              <tr>
                <th>Test Code</th>
                <th>Diagnostic Test Name</th>
                <th>Department</th>
                <th>Turnaround Time</th>
                <th>Standard Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong style="color: var(--primary);">LT-01</strong></td>
                <td><strong>Complete Blood Count (CBC) with ESR</strong></td>
                <td><span class="dept-tag">Hematology</span></td>
                <td><i class="fa-regular fa-clock"></i> 2 Hours</td>
                <td><strong>Rs. 650</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('Complete Blood Count (CBC)')">Book Test</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-02</strong></td>
                <td><strong>Beta hCG (Quantitative Pregnancy Test)</strong></td>
                <td><span class="dept-tag">Biochemistry</span></td>
                <td><i class="fa-regular fa-clock"></i> 3 Hours</td>
                <td><strong>Rs. 1,800</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('Beta hCG Test')">Book Test</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-03</strong></td>
                <td><strong>Blood Glucose Fasting / Random</strong></td>
                <td><span class="dept-tag">Biochemistry</span></td>
                <td><i class="fa-regular fa-clock"></i> 30 Mins</td>
                <td><strong>Rs. 200</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('Blood Glucose')">Book Test</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-04</strong></td>
                <td><strong>HbA1c (Glycated Hemoglobin)</strong></td>
                <td><span class="dept-tag">Biochemistry</span></td>
                <td><i class="fa-regular fa-clock"></i> 4 Hours</td>
                <td><strong>Rs. 1,400</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('HbA1c')">Book Test</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-05</strong></td>
                <td><strong>Urine Routine Examination (R/E)</strong></td>
                <td><span class="dept-tag">Clinical Path</span></td>
                <td><i class="fa-regular fa-clock"></i> 1 Hour</td>
                <td><strong>Rs. 350</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('Urine Routine')">Book Test</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-09</strong></td>
                <td><strong>Pelvic / Obstetric Ultrasound (2D/3D)</strong></td>
                <td><span class="dept-tag">Radiology</span></td>
                <td><i class="fa-regular fa-clock"></i> 30 Mins</td>
                <td><strong>Rs. 1,500</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('Ultrasound Services (USG)')">Book Scan</button></td>
              </tr>
              <tr>
                <td><strong style="color: var(--primary);">LT-11</strong></td>
                <td><strong>Digital 12-Lead ECG with Doctor Note</strong></td>
                <td><span class="dept-tag">Cardiology</span></td>
                <td><i class="fa-regular fa-clock"></i> 15 Mins</td>
                <td><strong>Rs. 700</strong></td>
                <td><button class="btn btn-sm btn-outline" onclick="openBookingModal('ECG Services')">Book ECG</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Live Receptionist & Token Queue Desk -->
  <section class="section queue-section" id="queue-desk">
    <div class="container">
      <div class="section-head">
        <span class="section-tag">Reception & OPD Queue</span>
        <h2>Live Token Desk & Patient Flow</h2>
        <p>Real-time queue monitoring connected to our clinic database. Patients can view current queue status.</p>
      </div>

      <div class="desk-grid">
        <!-- New Token Registration Form -->
        <div class="desk-control-card">
          <div class="card-heading-row">
            <h3><i class="fa-solid fa-id-card-clip"></i> Issue Walk-In Token</h3>
            <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">Fast Entry</span>
          </div>

          <form id="publicQuickTokenForm" class="quick-form">
            <div class="form-group">
              <label for="quickTokenName">Patient Full Name *</label>
              <input type="text" id="quickTokenName" class="form-control" placeholder="Enter patient name" required>
            </div>

            <div class="form-group">
              <label for="quickTokenService">Department / Service *</label>
              <select id="quickTokenService" class="form-control" required>
                <option value="Lady Doctor">Lady Doctor (Gynecology OPD)</option>
                <option value="Maternity Care">Maternity & Delivery Care</option>
                <option value="Ultrasound">Ultrasound (Female Sonologist)</option>
                <option value="Laboratory">Laboratory Testing</option>
                <option value="ECG">ECG Screening</option>
                <option value="Pharmacy">Medical Store / Pharmacy</option>
              </select>
            </div>

            <div class="form-group">
              <label for="quickTokenPhone">Phone Number</label>
              <input type="tel" id="quickTokenPhone" class="form-control" placeholder="0300-XXXXXXX">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;" id="quickTokenSubmitBtn">
              <i class="fa-solid fa-ticket"></i> Generate OPD Token Slip
            </button>
          </form>
        </div>

        <!-- Live Queue Board -->
        <div class="queue-board-card">
          <div class="card-heading-row">
            <h3><i class="fa-solid fa-users"></i> Current OPD Queue</h3>
            <div class="live-indicator">
              <div class="live-dot"></div> Live Database
            </div>
          </div>

          <div class="queue-list" id="queueListContainer">
            @forelse($queue as $item)
              <div class="queue-item">
                <div style="display:flex; align-items:center; gap: 0.85rem;">
                  <span class="queue-token-badge">{{ $item->token_number }}</span>
                  <div class="queue-patient-meta">
                    <h5>{{ $item->patient_name }}</h5>
                    <p><i class="fa-solid fa-stethoscope"></i> {{ $item->service }} &bull; <i class="fa-regular fa-clock"></i> {{ $item->queue_time }}</p>
                  </div>
                </div>
                <div>
                  <span class="status-badge status-{{ str_replace(' ', '-', $item->status) }}">
                    {{ $item->status }}
                  </span>
                </div>
              </div>
            @empty
              <div style="text-align:center; padding: 2rem; color: var(--gray-500);">Queue is currently empty.</div>
            @endforelse
          </div>

          <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--gray-500); display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-info-circle"></i> Synced with Clinic Reception Desk</span>
            <span>Total Active: {{ count($queue) }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Online Report Verification Banner -->
  <section class="container" id="report-portal">
    <div class="report-banner">
      <div class="container report-banner-inner">
        <div class="report-banner-text">
          <span style="background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Diagnostic Portal</span>
          <h3>Online Patient Diagnostic Reports</h3>
          <p>Already got a test done? Enter your Report ID or Token number to view and print your lab, ultrasound, or ECG report online.</p>
          <div style="margin-top: 0.75rem; font-size: 0.82rem; color: #94a3b8; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
            <span>Try demo IDs:</span>
            <button type="button" class="btn btn-sm" style="background: rgba(255,255,255,0.15); color: #fff;" onclick="searchReport('REP-101')">REP-101 (Ultrasound)</button>
            <button type="button" class="btn btn-sm" style="background: rgba(255,255,255,0.15); color: #fff;" onclick="searchReport('REP-102')">REP-102 (Lab/Pregnancy)</button>
            <button type="button" class="btn btn-sm" style="background: rgba(255,255,255,0.15); color: #fff;" onclick="searchReport('REP-103')">REP-103 (ECG)</button>
          </div>
        </div>

        <form id="publicReportSearchForm" class="report-search-box" onsubmit="event.preventDefault(); searchReport(document.getElementById('reportSearchIdInput').value);">
          <input type="text" id="reportSearchIdInput" placeholder="Enter Report ID (e.g. REP-101)" required>
          <button type="submit" class="btn btn-pink">
            <i class="fa-solid fa-magnifying-glass"></i> View Report
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Pharmacy Feature Section -->
  <section class="section pharmacy-section">
    <div class="container pharmacy-feature-grid">
      <div class="pharmacy-img-wrap">
        <img src="https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=700&q=80" alt="Clinic Pharmacy">
      </div>
      <div>
        <span class="section-tag pharmacy-tag">24/7 Medical Store</span>
        <h2 class="pharmacy-heading">
          In-House Pharmacy & Genuine Medicines
        </h2>
        <p class="pharmacy-desc">
          We stock comprehensive mother & baby healthcare items, routine gynecological medicines, surgical disposables, temperature-sensitive vaccines, and emergency cardiovascular medications.
        </p>
        <div class="pharmacy-perks-grid">
          <div class="pharmacy-perk-card">
            <h5><i class="fa-solid fa-truck-medical" style="color: var(--primary);"></i> Free Local Delivery</h5>
            <p>Within 3 km radius for urgent prescriptions.</p>
          </div>
          <div class="pharmacy-perk-card">
            <h5><i class="fa-solid fa-shield-virus" style="color: var(--primary);"></i> 100% Guaranteed</h5>
            <p>Sourced directly from licensed pharmaceutical distributors.</p>
          </div>
        </div>
        <a href="https://wa.me/923001234567?text=Hi,%20I%20want%20to%20inquire%20about%20medicines%20from%20Al-Noor%20Pharmacy" target="_blank" class="btn btn-primary" id="pharmacyWaBtn">
          <i class="fa-brands fa-whatsapp"></i> Order Medicines via WhatsApp
        </a>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="section contact-section" id="contact">
    <div class="container">
      <div class="section-head">
        <span class="section-tag">Reach Us</span>
        <h2>Visit Al-Noor Clinic & Diagnostics</h2>
        <p>Easily accessible central location with ample parking and dedicated ambulance access.</p>
      </div>

      <div class="contact-cards-grid">
        <div class="contact-card">
          <div class="contact-card-icon blue">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <h4>Clinic Address</h4>
          <p>Healthcare Plaza, Block C, Main Boulevard, Near Civil Hospital</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-icon pink">
            <i class="fa-solid fa-phone-volume"></i>
          </div>
          <h4>Emergency & Helpline</h4>
          <p>24/7 Hotlines: <br><strong>+92 311 9876543</strong><br>+92 300 1234567</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-icon green">
            <i class="fa-solid fa-clock"></i>
          </div>
          <h4>Operational Hours</h4>
          <p>Labor Room & Medical Store: <strong>24/7</strong><br>OPD & Lab: 09:00 AM - 10:00 PM</p>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  // Lab Search filter in table
  const searchInput = document.getElementById('labSearchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase().trim();
      const rows = document.querySelectorAll('#labTestsTable tbody tr');
      rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
      });
    });
  }

  // Quick Token Form submit via AJAX
  const quickForm = document.getElementById('publicQuickTokenForm');
  if (quickForm) {
    quickForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('quickTokenSubmitBtn');
      btn.disabled = true;

      const payload = {
        patient_name: document.getElementById('quickTokenName').value,
        service: document.getElementById('quickTokenService').value,
        phone: document.getElementById('quickTokenPhone').value,
      };

      try {
        const res = await fetch("{{ route('public.token.quick') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (data.success) {
          showToast(data.message);
          quickForm.reset();
          // prepend to queue list
          const list = document.getElementById('queueListContainer');
          const newItem = document.createElement('div');
          newItem.className = 'queue-item';
          newItem.innerHTML = `
            <div style="display:flex; align-items:center; gap: 0.85rem;">
              <span class="queue-token-badge">${data.data.token_number}</span>
              <div class="queue-patient-meta">
                <h5>${data.data.patient_name}</h5>
                <p><i class="fa-solid fa-stethoscope"></i> ${data.data.service} &bull; <i class="fa-regular fa-clock"></i> ${data.data.queue_time}</p>
              </div>
            </div>
            <div>
              <span class="status-badge status-Waiting">${data.data.status}</span>
            </div>
          `;
          list.prepend(newItem);
        }
      } catch (err) {
        showToast('Error issuing token', 'error');
      } finally {
        btn.disabled = false;
      }
    });
  }
</script>
@endpush
