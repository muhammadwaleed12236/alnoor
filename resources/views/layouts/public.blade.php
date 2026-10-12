<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Al-Noor Mother & Child Health Clinic | Diagnostic Centre')</title>
  <meta name="description" content="Premier Mother & Child Care, Lady Doctor, Maternity & Delivery, 24/7 Medical Store, Pathology Lab, Ultrasound and ECG Services.">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('styles')
</head>
<body>

  <!-- Top Emergency Bar -->
  <aside class="top-bar" aria-label="Emergency and Working Hours">
    <div class="container top-bar-content">
      <div class="top-bar-left">
        <span class="top-badge"><i class="fa-solid fa-bell"></i> 24/7 EMERGENCY</span>
        <span><i class="fa-solid fa-clock"></i> OPD: 09:00 AM - 10:00 PM | Emergency & Delivery 24/7</span>
      </div>
      <div class="top-bar-right">
        <a href="tel:+923119876543" id="topEmergencyCall"><i class="fa-solid fa-phone-volume"></i> Emergency: +92 311 9876543</a>
        <a href="https://wa.me/923001234567" target="_blank" rel="noopener" id="topWhatsApp"><i class="fa-brands fa-whatsapp"></i> WhatsApp Help</a>
        @auth
          <a href="{{ route('admin.dashboard') }}" style="background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 4px;">
            <i class="fa-solid fa-gauge"></i> Staff Dashboard
          </a>
        @else
          <a href="{{ route('admin.login') }}" style="color: #cbd5e1; font-size: 0.76rem;">
            <i class="fa-solid fa-lock"></i> Staff Login
          </a>
        @endauth
      </div>
    </div>
  </aside>

  <!-- Navigation -->
  <header class="main-header">
    <div class="container nav-container">
      <a href="{{ route('home') }}" class="logo-area" id="logoLink">
        <div class="logo-icon-box">
          <i class="fa-solid fa-hand-holding-medical"></i>
        </div>
        <div class="logo-text">
          <h1>Al-Noor Clinic</h1>
          <span>Maternity & Diagnostic Centre</span>
        </div>
      </a>

      <nav>
        <ul class="nav-links" id="navLinks">
          <li><a href="#services" class="active">Services</a></li>
          <li><a href="#doctors">Specialists</a></li>
          <li><a href="#lab-tests">Lab Directory</a></li>
          <li><a href="#queue-desk">Live Queue</a></li>
          <li><a href="#report-portal">Online Reports</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>

      <div class="nav-actions">
        <button class="btn btn-primary" id="openBookModalBtn">
          <i class="fa-regular fa-calendar-check"></i> Book Appointment
        </button>
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle navigation menu">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <div class="logo-area" style="margin-bottom: 1.25rem;">
            <div class="logo-icon-box" style="background: var(--primary);">
              <i class="fa-solid fa-hand-holding-medical"></i>
            </div>
            <div class="logo-text">
              <h1 style="color: #fff; font-size: 1.15rem;">Al-Noor Clinic</h1>
              <span style="color: #38bdf8;">Mother & Child Care</span>
            </div>
          </div>
          <p>
            Dedicated maternal, diagnostic, and family healthcare clinic delivering high precision clinical testing, expert lady doctor consultations, and 24/7 emergency services.
          </p>
        </div>

        <div class="footer-col">
          <h4>Clinical Services</h4>
          <div class="footer-links">
            <a href="#services"><i class="fa-solid fa-angle-right"></i> Lady Doctor OPD</a>
            <a href="#services"><i class="fa-solid fa-angle-right"></i> Maternity & Delivery Care</a>
            <a href="#services"><i class="fa-solid fa-angle-right"></i> Ultrasound Services</a>
            <a href="#services"><i class="fa-solid fa-angle-right"></i> Laboratory Testing</a>
            <a href="#services"><i class="fa-solid fa-angle-right"></i> Instant 12-Lead ECG</a>
            <a href="#services"><i class="fa-solid fa-angle-right"></i> 24/7 Medical Store</a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Quick Access</h4>
          <div class="footer-links">
            <a href="#home"><i class="fa-solid fa-angle-right"></i> Book Appointment</a>
            <a href="#report-portal"><i class="fa-solid fa-angle-right"></i> Download Reports</a>
            <a href="#queue-desk"><i class="fa-solid fa-angle-right"></i> Live OPD Queue</a>
            <a href="#lab-tests"><i class="fa-solid fa-angle-right"></i> Lab Test Rates</a>
            <a href="{{ route('admin.login') }}"><i class="fa-solid fa-angle-right"></i> Doctor / Staff Login</a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Contact Clinic</h4>
          <ul class="footer-contact-list">
            <li><i class="fa-solid fa-location-dot"></i> Healthcare Plaza, Block C, Main Boulevard</li>
            <li><i class="fa-solid fa-phone"></i> +92 311 9876543 (Emergency)</li>
            <li><i class="fa-solid fa-clock"></i> Open 24/7 for Emergencies</li>
            <li><i class="fa-solid fa-envelope"></i> care@alnoorclinic.com</li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Al-Noor Mother & Child Clinic & Diagnostic Centre. All rights reserved.</p>
        <p>Dynamic Clinic Management System &bull; Powered by Laravel</p>
      </div>
    </div>
  </footer>

  <!-- Floating Mobile Quick Actions Bar (Mobile Only) -->
  <aside class="mobile-bottom-bar" id="mobileBottomBar" aria-label="Mobile Quick Actions">
    <a href="tel:+923119876543" class="mobile-bar-btn call-btn">
      <i class="fa-solid fa-phone-volume"></i>
      <span>Emergency</span>
    </a>
    <button class="mobile-bar-btn book-btn" onclick="openBookingModal('Lady Doctor & Gynae OPD')">
      <i class="fa-solid fa-calendar-check"></i>
      <span>Book OPD</span>
    </button>
    <a href="https://wa.me/923001234567" target="_blank" rel="noopener" class="mobile-bar-btn wa-btn">
      <i class="fa-brands fa-whatsapp"></i>
      <span>WhatsApp</span>
    </a>
  </aside>

  <!-- ==========================================================================
       MODAL 1: APPOINTMENT BOOKING & PRINTABLE TOKEN SLIP
       ========================================================================== -->
  <div class="modal-overlay" id="bookingModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="bookingModalTitle"><i class="fa-regular fa-calendar-check" style="color: var(--primary);"></i> Book Clinic Appointment</h3>
        <button class="modal-close-btn" onclick="closeModal('bookingModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div id="bookingFormSection">
          <form id="appointmentForm" class="quick-form">
            <div class="form-group">
              <label for="modalPatientName">Patient Full Name *</label>
              <input type="text" id="modalPatientName" class="form-control" placeholder="e.g. Fatima Tariq" required>
            </div>

            <div class="form-row-2col">
              <div class="form-group">
                <label for="modalPatientAge">Age</label>
                <input type="text" id="modalPatientAge" class="form-control" placeholder="e.g. 28 Yrs">
              </div>
              <div class="form-group">
                <label for="modalPatientGender">Gender</label>
                <select id="modalPatientGender" class="form-control">
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                  <option value="Child">Child</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="modalServiceSelect">Service Required *</label>
              <select id="modalServiceSelect" class="form-control" required>
                @if(isset($services))
                  @foreach($services as $srv)
                    <option value="{{ $srv->title }}">{{ $srv->title }}</option>
                  @endforeach
                @else
                  <option value="Lady Doctor & Gynae OPD">Lady Doctor & Gynae OPD</option>
                  <option value="Maternity & Delivery Care">Maternity & Delivery Care</option>
                  <option value="Ultrasound Services (USG)">Ultrasound Services (USG)</option>
                  <option value="Laboratory Testing">Laboratory Testing</option>
                  <option value="ECG Services">ECG Services</option>
                  <option value="Medical Store (Pharmacy)">Medical Store (Pharmacy)</option>
                @endif
              </select>
            </div>

            <div class="form-row-2col">
              <div class="form-group">
                <label for="modalAppDate">Preferred Date</label>
                <input type="date" id="modalAppDate" class="form-control" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
              </div>
              <div class="form-group">
                <label for="modalAppSlot">Shift / Slot</label>
                <select id="modalAppSlot" class="form-control">
                  <option value="Morning (10:00 AM - 01:00 PM)">Morning (10:00 AM - 01:00 PM)</option>
                  <option value="Evening (05:00 PM - 09:00 PM)">Evening (05:00 PM - 09:00 PM)</option>
                  <option value="Emergency (Immediate)">Emergency (Immediate)</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="modalPatientPhone">Contact Phone Number *</label>
              <input type="tel" id="modalPatientPhone" class="form-control" placeholder="0300-1234567" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;" id="submitBookingBtn">
              <i class="fa-solid fa-circle-check"></i> Confirm & Generate Token Slip
            </button>
          </form>
        </div>

        <!-- Generated Token Result -->
        <div id="bookingResultSection" style="display: none;">
          <div class="printable-area" id="tokenSlipArea">
            <div class="token-slip">
              <div class="token-slip-header">
                <h4 style="font-size: 1.15rem; font-weight: 800; color: var(--primary);">Al-Noor Mother & Child Clinic</h4>
                <p style="font-size: 0.75rem; color: var(--gray-500);">OPD & DIAGNOSTIC APPOINTMENT TOKEN</p>
              </div>

              <div class="token-number-box" id="resTokenNumber">
                TK-101
              </div>

              <div class="token-details-grid">
                <p><strong>Patient:</strong> <span id="resPatientName">-</span></p>
                <p><strong>Service:</strong> <span id="resService">-</span></p>
                <p><strong>Date:</strong> <span id="resDate">-</span></p>
                <p><strong>Slot:</strong> <span id="resSlot">-</span></p>
                <p><strong>MR Number:</strong> <span id="resMRN">-</span></p>
                <p><strong>Fee Status:</strong> <span>Pay at Reception</span></p>
              </div>

              <p style="font-size: 0.75rem; color: var(--gray-500); margin-bottom: 0.5rem;">
                Please present this token at the reception desk 15 minutes before your time slot.
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 0.75rem; margin-top: 1.25rem;" class="no-print">
            <button class="btn btn-primary" style="flex: 1;" onclick="window.print()">
              <i class="fa-solid fa-print"></i> Print Token Slip
            </button>
            <button class="btn btn-outline" style="flex: 1;" onclick="resetBookingForm()">
              <i class="fa-solid fa-plus"></i> New Appointment
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================================================
       MODAL 2: MEDICAL REPORT VIEWER
       ========================================================================== -->
  <div class="modal-overlay" id="reportModal">
    <div class="modal-content modal-report-size">
      <div class="modal-header">
        <h3><i class="fa-solid fa-file-waveform" style="color: var(--primary);"></i> Diagnostic Test Report</h3>
        <button class="modal-close-btn" onclick="closeModal('reportModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div class="printable-area" id="diagnosticReportArea">
          <div class="report-paper">
            <div class="report-clinic-header">
              <div>
                <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--primary);">Al-Noor Clinic & Diagnostics</h2>
                <p style="font-size: 0.75rem; color: var(--gray-500);">ISO 9001:2015 Compliant Clinical Laboratory & Ultrasound Centre</p>
                <p style="font-size: 0.75rem; color: var(--gray-500);">Main Boulevard, Healthcare Plaza | Ph: +92 311 9876543</p>
              </div>
              <div style="text-align: right;">
                <span class="badge" style="background: #dcfce7; color: #166534; font-size: 0.8rem; font-weight: 800; padding: 4px 10px; border-radius: 4px;">VERIFIED REPORT</span>
                <p style="font-size: 0.75rem; color: var(--gray-500); margin-top: 4px;" id="repIssueDate">Date: -</p>
              </div>
            </div>

            <!-- Patient Information Bar -->
            <div class="report-patient-meta">
              <div><strong>Patient Name:</strong> <span id="repPatientName">-</span></div>
              <div><strong>Age / Gender:</strong> <span id="repPatientAge">-</span></div>
              <div><strong>MR Number:</strong> <span id="repMRN">-</span></div>
              <div><strong>Referring Doctor:</strong> <span id="repDoctor">-</span></div>
              <div><strong>Diagnostic Category:</strong> <span id="repCategory">-</span></div>
              <div><strong>Report ID:</strong> <span id="repReportId">-</span></div>
            </div>

            <h4 style="font-size: 1.05rem; font-weight: 800; color: var(--dark); margin-bottom: 0.75rem;" id="repTestTitle">
              Test Investigation Title
            </h4>

            <!-- Parameters Table -->
            <table class="report-table">
              <thead>
                <tr>
                  <th>Investigation Parameter</th>
                  <th>Observed Value</th>
                  <th>Reference / Normal Interval</th>
                </tr>
              </thead>
              <tbody id="repFindingsBody">
                <!-- Injected via AJAX -->
              </tbody>
            </table>

            <!-- Clinical Impression -->
            <div class="report-impression">
              <strong style="color: var(--primary); display: block; margin-bottom: 4px;"><i class="fa-solid fa-stethoscope"></i> Clinical Impression / Remarks:</strong>
              <p id="repImpressionText">-</p>
            </div>

            <!-- Signatures -->
            <div class="report-signatures">
              <div>
                <p>Medical Technologist</p>
                <strong style="color: var(--dark); font-size: 0.75rem;">Verified by Senior Tech</strong>
              </div>
              <div style="text-align: right;">
                <p>Consultant In-Charge</p>
                <strong style="color: var(--dark); font-size: 0.85rem;" id="repConsultantName">-</strong>
              </div>
            </div>
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem;" class="no-print">
          <button class="btn btn-primary" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Print Official Report
          </button>
          <button class="btn btn-outline" onclick="closeModal('reportModal')">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification Container -->
  <div class="toast-container" id="toastContainer"></div>

  <!-- Scripts -->
  <script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modals
    function openBookingModal(serviceName = '') {
      resetBookingForm();
      const select = document.getElementById('modalServiceSelect');
      if (serviceName && select) {
        for (let opt of select.options) {
          if (opt.value.toLowerCase().includes(serviceName.toLowerCase()) || serviceName.toLowerCase().includes(opt.value.toLowerCase())) {
            opt.selected = true;
            break;
          }
        }
      }
      document.getElementById('bookingModal').classList.add('active');
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove('active');
    }

    function resetBookingForm() {
      document.getElementById('appointmentForm').reset();
      document.getElementById('bookingFormSection').style.display = 'block';
      document.getElementById('bookingResultSection').style.display = 'none';
    }

    // Dynamic AJAX Appointment Booking
    document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('submitBookingBtn');
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

      const payload = {
        patient_name: document.getElementById('modalPatientName').value,
        patient_age: document.getElementById('modalPatientAge').value,
        patient_gender: document.getElementById('modalPatientGender').value,
        service_name: document.getElementById('modalServiceSelect').value,
        appointment_date: document.getElementById('modalAppDate').value,
        slot: document.getElementById('modalAppSlot').value,
        patient_phone: document.getElementById('modalPatientPhone').value,
      };

      try {
        const res = await fetch("{{ route('public.book') }}", {
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
          document.getElementById('resTokenNumber').innerText = data.data.token_number;
          document.getElementById('resPatientName').innerText = data.data.patient_name;
          document.getElementById('resService').innerText = data.data.service;
          document.getElementById('resDate').innerText = data.data.date;
          document.getElementById('resSlot').innerText = data.data.slot;
          document.getElementById('resMRN').innerText = data.data.mr_number;

          document.getElementById('bookingFormSection').style.display = 'none';
          document.getElementById('bookingResultSection').style.display = 'block';
          showToast(data.message);
        } else {
          showToast(data.message || 'Error booking appointment', 'error');
        }
      } catch (err) {
        showToast('Server error. Please try again.', 'error');
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Confirm & Generate Token Slip';
      }
    });

    // Dynamic AJAX Report Search
    async function searchReport(reportId) {
      if (!reportId) return;
      showToast('Searching diagnostic report...');

      try {
        const res = await fetch(`{{ route('public.report.search') }}?report_id=${encodeURIComponent(reportId)}`, {
          headers: { 'Accept': 'application/json' }
        });

        const data = await res.json();
        if (data.success && data.report) {
          const rep = data.report;
          document.getElementById('repPatientName').innerText = rep.patient_name;
          document.getElementById('repPatientAge').innerText = `${rep.age} / ${rep.gender}`;
          document.getElementById('repMRN').innerText = rep.mrn || '-';
          document.getElementById('repDoctor').innerText = rep.doctor || '-';
          document.getElementById('repCategory').innerText = rep.category;
          document.getElementById('repReportId').innerText = rep.report_id;
          document.getElementById('repTestTitle').innerText = rep.test_name;
          document.getElementById('repIssueDate').innerText = `Date: ${rep.date}`;
          document.getElementById('repImpressionText').innerText = rep.impression || 'Normal findings.';
          document.getElementById('repConsultantName').innerText = rep.consultant || 'Duty Consultant';

          const tbody = document.getElementById('repFindingsBody');
          tbody.innerHTML = rep.findings.map(f => `
            <tr>
              <td><strong>${f.param}</strong></td>
              <td><strong style="color: var(--primary);">${f.value}</strong></td>
              <td style="color: var(--gray-500); font-size: 0.82rem;">${f.normal}</td>
            </tr>
          `).join('');

          document.getElementById('reportModal').classList.add('active');
        } else {
          showToast(data.message || 'Report not found', 'error');
        }
      } catch (err) {
        showToast('Unable to fetch report. Please try again.', 'error');
      }
    }

    // Toast helper
    function showToast(message, type = 'success') {
      const container = document.getElementById('toastContainer');
      const toast = document.createElement('div');
      toast.className = 'toast';
      if (type === 'error') toast.style.borderLeftColor = 'var(--danger)';

      toast.innerHTML = `
        <i class="fa-solid ${type === 'error' ? 'fa-triangle-exclamation' : 'fa-circle-check'}" style="color: ${type === 'error' ? '#ef4444' : '#10b981'};"></i>
        <span>${message}</span>
      `;
      container.appendChild(toast);
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
      }, 3500);
    }

    // Mobile nav toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    if (mobileBtn && navLinks) {
      mobileBtn.addEventListener('click', () => navLinks.classList.toggle('active'));
      navLinks.querySelectorAll('a').forEach(l => l.addEventListener('click', () => navLinks.classList.remove('active')));
      document.addEventListener('click', (e) => {
        if (!navLinks.contains(e.target) && !mobileBtn.contains(e.target)) navLinks.classList.remove('active');
      });
    }

    // Close modals on overlay background click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
