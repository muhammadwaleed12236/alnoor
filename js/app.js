/**
 * Al-Noor Clinic Management Web Application
 * Client-Side Logic & Dynamic Interactions
 */

// Application State
let liveQueue = [...INITIAL_QUEUE];

document.addEventListener("DOMContentLoaded", () => {
  initDateInput();
  renderServices();
  renderDoctors();
  renderLabTests(LAB_TESTS_CATALOG);
  renderQueue();
  setupEventListeners();
});

/**
 * Initialize default date to today
 */
function initDateInput() {
  const dateInput = document.getElementById("modalAppDate");
  if (dateInput) {
    const today = new Date().toISOString().split("T")[0];
    dateInput.value = today;
    dateInput.min = today;
  }
}

/**
 * Render the 6 Main Services
 */
function renderServices() {
  const container = document.getElementById("servicesContainer");
  if (!container) return;

  container.innerHTML = SERVICES_DATA.map(service => `
    <article class="service-card ${service.id === 'maternity-care' || service.id === 'lady-doctor' ? 'pink-accent' : ''}">
      <div class="card-top">
        <div class="card-icon">
          <i class="fa-solid ${service.icon}"></i>
        </div>
        <span class="service-badge ${service.id === 'maternity-care' || service.id === 'lady-doctor' ? 'pink' : ''}">
          ${service.badge}
        </span>
      </div>
      <h3>${service.title}</h3>
      <p class="service-desc">${service.shortDesc}</p>
      
      <ul class="feature-list">
        ${service.features.map(f => `<li><i class="fa-solid fa-check"></i> ${f}</li>`).join("")}
      </ul>

      <div class="service-meta">
        <div>
          <span style="display:block; font-size:0.72rem; color:var(--gray-500);">Charges / Fee</span>
          <span class="service-price">${service.startingFee}</span>
        </div>
        <button class="btn btn-sm btn-primary" onclick="openBookingModal('${service.title}')">
          <i class="fa-solid fa-calendar-plus"></i> Book Now
        </button>
      </div>
    </article>
  `).join("");
}

/**
 * Render Doctor & Specialist Profiles
 */
function renderDoctors() {
  const container = document.getElementById("doctorsContainer");
  if (!container) return;

  container.innerHTML = DOCTORS_DATA.map(doc => `
    <div class="doctor-card">
      <div class="doctor-img-wrap">
        <img src="${doc.avatar}" alt="${doc.name}" loading="lazy">
        <span class="doc-exp-badge">${doc.experience}</span>
      </div>
      <div class="doctor-info">
        <h4>${doc.name}</h4>
        <div class="doc-qual">${doc.qualification}</div>
        <div class="doc-role">${doc.role}</div>
        <div class="doc-timing">
          <i class="fa-regular fa-clock"></i> ${doc.timings}
        </div>
        <button class="btn btn-sm btn-outline" style="width: 100%;" onclick="openBookingModal('${doc.role}')">
          Consult Doctor
        </button>
      </div>
    </div>
  `).join("");
}

/**
 * Render Lab Test Price Directory
 */
function renderLabTests(tests) {
  const tbody = document.getElementById("labTestsTbody");
  if (!tbody) return;

  if (tests.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding: 2rem; color: var(--gray-500);">No diagnostic tests found matching your search.</td></tr>`;
    return;
  }

  tbody.innerHTML = tests.map(test => `
    <tr>
      <td><strong style="color: var(--primary); font-size: 0.8rem;">${test.code}</strong></td>
      <td><strong>${test.name}</strong></td>
      <td><span class="dept-tag">${test.dept}</span></td>
      <td><i class="fa-regular fa-clock" style="color:var(--gray-500); margin-right:4px;"></i> ${test.time}</td>
      <td><strong style="color: var(--dark);">Rs. ${test.price.toLocaleString()}</strong></td>
      <td>
        <button class="btn btn-sm btn-outline" onclick="openBookingModal('${test.name}')">
          Book Test
        </button>
      </td>
    </tr>
  `).join("");
}

/**
 * Render Live Patient Queue
 */
function renderQueue() {
  const container = document.getElementById("queueListContainer");
  const countEl = document.getElementById("queueCount");
  if (!container) return;

  if (countEl) {
    countEl.innerText = `Total in Queue: ${liveQueue.length}`;
  }

  if (liveQueue.length === 0) {
    container.innerHTML = `<div style="text-align:center; padding: 2rem; color: var(--gray-500);">Queue is currently empty.</div>`;
    return;
  }

  container.innerHTML = liveQueue.map(item => `
    <div class="queue-item" id="queue-${item.id}">
      <div style="display:flex; align-items:center; gap: 0.85rem;">
        <span class="queue-token-badge">${item.token}</span>
        <div class="queue-patient-meta">
          <h5>${item.name}</h5>
          <p><i class="fa-solid fa-stethoscope"></i> ${item.service} &bull; <i class="fa-regular fa-clock"></i> ${item.time}</p>
        </div>
      </div>
      <div style="display: flex; align-items: center; gap: 0.65rem;">
        <span class="status-badge status-${item.status}" 
              style="cursor: pointer;" 
              title="Click to change status" 
              onclick="cycleQueueStatus('${item.id}')">
          ${item.status}
        </span>
        <button style="background:none; border:none; color: var(--gray-500); cursor:pointer;" title="Remove from queue" onclick="removeQueueItem('${item.id}')">
          <i class="fa-solid fa-trash-can"></i>
        </button>
      </div>
    </div>
  `).join("");
}

/**
 * Cycle Queue Item Status
 */
function cycleQueueStatus(id) {
  const item = liveQueue.find(q => q.id === id);
  if (!item) return;

  if (item.status === "Waiting") {
    item.status = "In-Consultation";
    showToast(`Token ${item.token} is now In-Consultation`);
  } else if (item.status === "In-Consultation") {
    item.status = "Completed";
    showToast(`Token ${item.token} marked as Completed`);
  } else {
    item.status = "Waiting";
    showToast(`Token ${item.token} reset to Waiting`);
  }

  renderQueue();
}

/**
 * Remove Queue Item
 */
function removeQueueItem(id) {
  liveQueue = liveQueue.filter(q => q.id !== id);
  renderQueue();
  showToast("Patient removed from queue.");
}

/**
 * Setup Event Listeners
 */
function setupEventListeners() {
  // Mobile Nav Toggle & Auto-Close
  const mobileBtn = document.getElementById("mobileMenuBtn");
  const navLinks = document.getElementById("navLinks");
  if (mobileBtn && navLinks) {
    mobileBtn.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });

    // Close menu when clicking on any navigation link
    navLinks.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        navLinks.classList.remove("active");
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", (e) => {
      if (!navLinks.contains(e.target) && !mobileBtn.contains(e.target)) {
        navLinks.classList.remove("active");
      }
    });
  }

  // Book Modal Open Buttons
  const openBookModalBtn = document.getElementById("openBookModalBtn");
  if (openBookModalBtn) {
    openBookModalBtn.addEventListener("click", () => openBookingModal());
  }

  const heroBookBtn = document.getElementById("heroBookBtn");
  if (heroBookBtn) {
    heroBookBtn.addEventListener("click", () => openBookingModal("Lady Doctor & Gynae OPD"));
  }

  // Lab Search Filter
  const labSearchInput = document.getElementById("labSearchInput");
  if (labSearchInput) {
    labSearchInput.addEventListener("input", (e) => {
      const q = e.target.value.toLowerCase().trim();
      const filtered = LAB_TESTS_CATALOG.filter(t => 
        t.name.toLowerCase().includes(q) || 
        t.dept.toLowerCase().includes(q) ||
        t.code.toLowerCase().includes(q)
      );
      renderLabTests(filtered);
    });
  }

  // Appointment Form Submit
  const appForm = document.getElementById("appointmentForm");
  if (appForm) {
    appForm.addEventListener("submit", (e) => {
      e.preventDefault();
      handleAppointmentSubmit();
    });
  }

  // Quick Token Desk Form Submit
  const quickTokenForm = document.getElementById("quickTokenForm");
  if (quickTokenForm) {
    quickTokenForm.addEventListener("submit", (e) => {
      e.preventDefault();
      handleQuickTokenSubmit();
    });
  }

  // Report Search Form
  const reportForm = document.getElementById("reportSearchForm");
  if (reportForm) {
    reportForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const input = document.getElementById("reportIdInput");
      if (input) {
        searchReport(input.value.trim());
      }
    });
  }

  // Close modals on clicking overlay background
  document.querySelectorAll(".modal-overlay").forEach(overlay => {
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) {
        overlay.classList.remove("active");
      }
    });
  });
}

/**
 * Open Booking Modal with pre-selected service
 */
function openBookingModal(serviceName = "") {
  const modal = document.getElementById("bookingModal");
  const serviceSelect = document.getElementById("modalServiceSelect");
  
  resetBookingForm();

  if (serviceName && serviceSelect) {
    // Check if exact option exists, else default or select closest
    let matched = false;
    for (let opt of serviceSelect.options) {
      if (opt.value.toLowerCase().includes(serviceName.toLowerCase()) || serviceName.toLowerCase().includes(opt.value.toLowerCase())) {
        opt.selected = true;
        matched = true;
        break;
      }
    }
    if (!matched) {
      serviceSelect.value = "Lady Doctor & Gynae OPD";
    }
  }

  if (modal) {
    modal.classList.add("active");
  }
}

/**
 * Close Modal helper
 */
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("active");
  }
}

/**
 * Handle Appointment Submission & Generate Token Slip
 */
function handleAppointmentSubmit() {
  const name = document.getElementById("modalPatientName").value.trim();
  const service = document.getElementById("modalServiceSelect").value;
  const date = document.getElementById("modalAppDate").value;
  const slot = document.getElementById("modalAppSlot").value;
  const phone = document.getElementById("modalPatientPhone").value;

  if (!name || !service) {
    showToast("Please fill in the required fields", "error");
    return;
  }

  const tokenNum = "TK-" + Math.floor(1000 + Math.random() * 9000);
  const mrn = "MR-" + Math.floor(1000 + Math.random() * 9000);

  // Fill in result section
  document.getElementById("resTokenNumber").innerText = tokenNum;
  document.getElementById("resPatientName").innerText = name;
  document.getElementById("resService").innerText = service;
  document.getElementById("resDate").innerText = date;
  document.getElementById("resSlot").innerText = slot;
  document.getElementById("resMRN").innerText = mrn;

  // Add to live queue as well
  const now = new Date();
  const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  liveQueue.unshift({
    id: tokenNum,
    token: tokenNum,
    name: name,
    service: service.split("&")[0].trim(),
    time: timeStr,
    status: "Waiting"
  });
  renderQueue();

  // Swap view inside modal
  document.getElementById("bookingFormSection").style.display = "none";
  document.getElementById("bookingResultSection").style.display = "block";

  showToast(`Token ${tokenNum} issued for ${name}!`);
}

/**
 * Handle Reception Quick Token Form
 */
function handleQuickTokenSubmit() {
  const nameInput = document.getElementById("tokenPatientName");
  const serviceSelect = document.getElementById("tokenServiceSelect");

  const name = nameInput.value.trim();
  const service = serviceSelect.value;
  if (!name) return;

  const tokenNum = "TK-" + Math.floor(1000 + Math.random() * 9000);
  const now = new Date();
  const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

  liveQueue.unshift({
    id: tokenNum,
    token: tokenNum,
    name: name,
    service: service,
    time: timeStr,
    status: "Waiting"
  });

  renderQueue();
  nameInput.value = "";
  document.getElementById("tokenPatientPhone").value = "";

  showToast(`OPD Token ${tokenNum} created successfully!`);
}

/**
 * Reset Appointment Form View
 */
function resetBookingForm() {
  const formSection = document.getElementById("bookingFormSection");
  const resultSection = document.getElementById("bookingResultSection");
  const form = document.getElementById("appointmentForm");

  if (form) form.reset();
  initDateInput();
  if (formSection) formSection.style.display = "block";
  if (resultSection) resultSection.style.display = "none";
}

/**
 * Search and View Diagnostic Medical Report
 */
function searchReport(reportId) {
  const formattedId = reportId.toUpperCase().trim();
  const report = MOCK_PATIENT_REPORTS[formattedId];

  if (!report) {
    showToast(`No diagnostic report found for "${reportId}". Try REP-101, REP-102, or REP-103.`, "error");
    return;
  }

  // Populate report fields
  document.getElementById("repPatientName").innerText = report.patientName;
  document.getElementById("repPatientAge").innerText = `${report.age} / ${report.gender}`;
  document.getElementById("repMRN").innerText = report.mrn;
  document.getElementById("repDoctor").innerText = report.doctor;
  document.getElementById("repCategory").innerText = report.category;
  document.getElementById("repReportId").innerText = formattedId;
  document.getElementById("repTestTitle").innerText = report.testName;
  document.getElementById("repIssueDate").innerText = `Date: ${report.date}`;
  document.getElementById("repImpressionText").innerText = report.impression;
  document.getElementById("repConsultantName").innerText = report.consultant;

  // Findings Table
  const tbody = document.getElementById("repFindingsBody");
  if (tbody) {
    tbody.innerHTML = report.findings.map(f => `
      <tr>
        <td><strong>${f.param}</strong></td>
        <td><strong style="color: var(--primary);">${f.value}</strong></td>
        <td style="color: var(--gray-500); font-size: 0.82rem;">${f.normal}</td>
      </tr>
    `).join("");
  }

  // Open modal
  const modal = document.getElementById("reportModal");
  if (modal) {
    modal.classList.add("active");
  }
}

/**
 * Print utility for specific printable area
 */
function printElement(elementId) {
  window.print();
}

/**
 * Toast Notification Helper
 */
function showToast(message, type = "success") {
  const container = document.getElementById("toastContainer");
  if (!container) return;

  const toast = document.createElement("div");
  toast.className = "toast";
  if (type === "error") {
    toast.style.borderLeftColor = "var(--danger)";
  }

  toast.innerHTML = `
    <i class="fa-solid ${type === 'error' ? 'fa-triangle-exclamation' : 'fa-circle-check'}" style="color: ${type === 'error' ? '#ef4444' : '#10b981'};"></i>
    <span>${message}</span>
  `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transform = "translateX(50px)";
    toast.style.transition = "all 0.3s ease";
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}
