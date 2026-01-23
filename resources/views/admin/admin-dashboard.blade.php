<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Dashboard - Biro Umum dan Pengadaan Barang dan Jasa</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets-admin/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets-admin/css/admin-dashboard.css">
</head>
<body>

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar shadow">
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-speedometer2 fs-5"></i>
        <span class="fw-semibold fs-6 sidebar-text">Admin Panel</span>
      </div>
      <button id="toggleSidebar" class="btn btn-sm text-white"><i class="bi bi-chevron-left"></i></button>
    </div>

    <ul class="nav flex-column px-2 mt-2">
      <li class="nav-item"><a href="/dashboard" class="nav-link active"><i class="bi bi-bar-chart me-2"></i><span class="sidebar-text">Dashboard</span></a></li>
      <li class="nav-item"><a href="/data-pelamar" class="nav-link"><i class="bi bi-people me-2"></i><span class="sidebar-text">Data Pelamar</span></a></li>
      <li class="nav-item"><a href="/lowongan" class="nav-link"><i class="bi bi-list-task me-2"></i><span class="sidebar-text">Lowongan</span></a></li>
      <li class="nav-item"><a href="" class="nav-link"><i class="bi bi-gear me-2"></i><span class="sidebar-text">Pengaturan</span></a></li>
    </ul>

    <div class="px-3 mt-auto pb-3">
      <a href="/login" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
        <i class="bi bi-box-arrow-right"></i>
        <span class="sidebar-text">Logout</span>
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <div id="main-content">
    <nav class="navbar navbar-light bg-white shadow-sm px-3 sticky-top">
      <button id="mobileToggle" class="btn btn-outline-primary d-lg-none me-2"><i class="bi bi-list"></i></button>
      <span class="fw-semibold text-primary">Dashboard Admin</span>
      <button id="refreshBtn" class="btn btn-outline-secondary btn-sm ms-auto"><i class="bi bi-arrow-clockwise me-1"></i> Refresh</button>
    </nav>

    <div class="container my-5">

      <!-- Filter -->
      <div class="card shadow-sm border-0 mb-4" data-aos="fade-up">
        <div class="card-body">
          <h6 class="fw-semibold text-primary mb-3"><i class="bi bi-funnel me-2"></i>Filter Berdasarkan Divisi</h6>
          <div id="filterDept" class="d-flex flex-column gap-2"></div>
          <button id="btnReset" class="btn btn-sm btn-outline-secondary mt-3">Reset</button>
        </div>
      </div>

      <!-- Statistik -->
      <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="col-md-3">
          <div class="card stat-card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
              <i class="bi bi-people-fill text-primary fs-1 mb-2"></i>
              <h6 class="text-muted mb-1">Total Pelamar</h6>
              <h4 id="totalApplicants" class="fw-bold mb-0">0</h4>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
              <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
              <h6 class="text-muted mb-1">Diterima</h6>
              <h4 id="acceptedApplicants" class="fw-bold mb-0">0</h4>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
              <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
              <h6 class="text-muted mb-1">Dalam Proses</h6>
              <h4 id="pendingApplicants" class="fw-bold mb-0">0</h4>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
              <i class="bi bi-x-circle-fill text-danger fs-1 mb-2"></i>
              <h6 class="text-muted mb-1">Ditolak</h6>
              <h4 id="rejectedApplicants" class="fw-bold mb-0">0</h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart -->
      <div class="card shadow-sm border-0 mb-5" data-aos="fade-up" data-aos-delay="200">
        <div class="card-body">
          <h6 class="fw-semibold text-primary mb-3">Statistik Pelamar per Divisi</h6>
          <canvas id="divisionChart" height="120"></canvas>
        </div>
      </div>

      <!-- Lowongan -->
      <div class="card shadow-sm border-0" data-aos="fade-up" data-aos-delay="300">
        <div class="card-body">
          <h6 class="fw-semibold text-primary mb-3">Daftar Lowongan Berdasarkan Divisi</h6>
          <div id="jobStats" class="row g-3"></div>
        </div>
      </div>

      <footer class="text-center text-muted small mt-5">
        © 2025 Biro Umum dan Pengadaan Barang dan Jasa — Dashboard Admin Magang
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="assets-admin/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="assets-admin/js/admin-dashboard.js"></script>
</body>
</html>
