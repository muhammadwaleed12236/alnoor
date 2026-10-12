<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard') - Al-Noor Clinic Management</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    /* Admin Specific Dashboard Styling */
    .admin-layout {
      display: flex;
      min-height: 100vh;
      background: #f1f5f9;
    }
    
    .admin-sidebar {
      width: 260px;
      background: #0f2b38;
      color: #cbd5e1;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .admin-sidebar-header {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .admin-nav {
      padding: 1rem 0.75rem;
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
      flex: 1;
      overflow-y: auto;
    }

    .admin-nav-item {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      padding: 0.75rem 1rem;
      border-radius: var(--radius-sm);
      color: #94a3b8;
      font-size: 0.88rem;
      font-weight: 600;
      transition: var(--transition);
      text-decoration: none;
    }

    .admin-nav-item:hover, .admin-nav-item.active {
      background: rgba(0, 119, 145, 0.25);
      color: #38bdf8;
    }

    .admin-nav-item i {
      font-size: 1.1rem;
      width: 22px;
    }

    .admin-main {
      flex: 1;
      margin-left: 260px;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .admin-topbar {
      height: 68px;
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.75rem;
      position: sticky;
      top: 0;
      z-index: 900;
    }

    .admin-content {
      padding: 2rem 1.75rem;
      flex: 1;
    }

    .dashboard-grid-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: #ffffff;
      padding: 1.35rem;
      border-radius: var(--radius-lg);
      border: 1px solid #e2e8f0;
      box-shadow: var(--shadow-sm);
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: var(--transition);
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
    }

    .stat-card h3 {
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 0.15rem;
    }

    .stat-card p {
      font-size: 0.8rem;
      color: var(--gray-500);
      font-weight: 600;
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--radius-md);
      display: grid;
      place-items: center;
      font-size: 1.3rem;
    }

    .stat-icon.teal { background: #e0f2fe; color: #0284c7; }
    .stat-icon.pink { background: #fce7f3; color: #db2777; }
    .stat-icon.green { background: #dcfce7; color: #166534; }
    .stat-icon.amber { background: #fef3c7; color: #d97706; }

    .content-box {
      background: #ffffff;
      border-radius: var(--radius-lg);
      border: 1px solid #e2e8f0;
      box-shadow: var(--shadow-sm);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .content-box-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.25rem;
      flex-wrap: wrap;
      gap: 0.75rem;
    }

    .content-box-header h3 {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .admin-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.88rem;
    }

    .admin-table th {
      background: #f8fafc;
      padding: 0.75rem 1rem;
      text-align: left;
      font-weight: 700;
      color: var(--dark);
      border-bottom: 2px solid #e2e8f0;
      white-space: nowrap;
    }

    .admin-table td {
      padding: 0.85rem 1rem;
      border-bottom: 1px solid #f1f5f9;
      color: var(--gray-700);
    }

    .admin-table tr:hover td {
      background: #f8fafc;
    }

    .alert {
      padding: 0.85rem 1.25rem;
      border-radius: var(--radius-md);
      margin-bottom: 1.25rem;
      font-size: 0.88rem;
      display: flex;
      align-items: center;
      gap: 0.65rem;
    }

    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    .badge-status {
      display: inline-block;
      padding: 3px 9px;
      border-radius: 9999px;
      font-size: 0.72rem;
      font-weight: 700;
    }

    .badge-Waiting { background: #fef3c7; color: #92400e; }
    .badge-In-Consultation { background: #dbeafe; color: #1e40af; }
    .badge-Completed { background: #dcfce7; color: #166534; }
    .badge-Cancelled { background: #fee2e2; color: #991b1b; }

    .admin-menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.35rem;
      color: var(--dark);
      cursor: pointer;
    }

    @media (max-width: 1024px) {
      .dashboard-grid-stats {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }
      .admin-sidebar.open {
        transform: translateX(0);
      }
      .admin-main {
        margin-left: 0;
      }
      .admin-menu-toggle {
        display: block;
      }
      .dashboard-grid-stats {
        grid-template-columns: 1fr;
      }
      .admin-content {
        padding: 1.25rem 1rem;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <div class="admin-layout">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="admin-sidebar-header">
        <div class="logo-icon-box" style="width: 38px; height: 38px; font-size: 1.15rem;">
          <i class="fa-solid fa-hand-holding-medical"></i>
        </div>
        <div class="logo-text">
          <h1 style="color: #fff; font-size: 1.05rem;">Al-Noor Clinic</h1>
          <span style="color: #38bdf8; font-size: 0.65rem;">Staff Management</span>
        </div>
      </div>

      <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-gauge-high"></i> Dashboard Overview
        </a>
        <a href="{{ route('admin.queue.index') }}" class="admin-nav-item {{ request()->routeIs('admin.queue.*') ? 'active' : '' }}">
          <i class="fa-solid fa-users-line"></i> Live Reception Queue
        </a>
        <a href="{{ route('admin.appointments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
          <i class="fa-regular fa-calendar-check"></i> Appointments & Tokens
        </a>
        <a href="{{ route('admin.diagnostics.index') }}" class="admin-nav-item {{ request()->routeIs('admin.diagnostics.*') ? 'active' : '' }}">
          <i class="fa-solid fa-file-waveform"></i> Diagnostics (Lab/USG/ECG)
        </a>
        <a href="{{ route('admin.pharmacy.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pharmacy.*') ? 'active' : '' }}">
          <i class="fa-solid fa-pills"></i> Medical Store (Pharmacy)
        </a>
        <a href="{{ route('admin.doctors.index') }}" class="admin-nav-item {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
          <i class="fa-solid fa-user-doctor"></i> Doctors & OPD Roster
        </a>
        <a href="{{ route('admin.patients.index') }}" class="admin-nav-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
          <i class="fa-solid fa-address-book"></i> Patients Registry (MRNs)
        </a>
        
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.08);">
          <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> View Public Portal
          </a>
        </div>
      </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
      <!-- Admin Topbar -->
      <header class="admin-topbar">
        <div style="display: flex; align-items: center; gap: 1rem;">
          <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-bars"></i>
          </button>
          <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--dark);">
            @yield('page_title', 'Clinic Dashboard')
          </h2>
        </div>

        <div style="display: flex; align-items: center; gap: 1.25rem;">
          <div style="display: flex; align-items: center; gap: 0.65rem;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: #e0f2fe; color: var(--primary); display: grid; place-items: center; font-weight: 800;">
              {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div style="display: none; @media(min-width: 640px){ display: block; }">
              <strong style="display: block; font-size: 0.85rem; color: var(--dark);">{{ Auth::user()->name ?? 'Admin Staff' }}</strong>
              <span style="font-size: 0.72rem; color: var(--gray-500);">Reception / Clinical</span>
            </div>
          </div>

          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline" title="Logout" style="padding: 0.4rem 0.75rem;">
              <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
          </form>
        </div>
      </header>

      <!-- Page Content -->
      <main class="admin-content">
        @if(session('success'))
          <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.2rem;">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('adminMenuToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
      });
      document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
          sidebar.classList.remove('open');
        }
      });
    }
  </script>
  @stack('scripts')
</body>
</html>
