<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Data Pelamar Magang</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets-admin/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets-admin/css/admin-applicants.css">
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
      <li class="nav-item"><a href="/dashboard" class="nav-link"><i class="bi bi-bar-chart me-2"></i><span class="sidebar-text">Dashboard</span></a></li>
      <li class="nav-item"><a href="/data-pelamar" class="nav-link active"><i class="bi bi-people me-2"></i><span class="sidebar-text">Data Pelamar</span></a></li>
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
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm px-3 sticky-top d-flex justify-content-between align-items-center">
      <button id="mobileToggle" class="btn btn-outline-primary d-lg-none me-2"><i class="bi bi-list"></i></button>
      <span class="fw-semibold text-primary">Data Pelamar Magang</span>
    </nav>

    <div class="container-fluid my-4 px-3 px-lg-5">

      <!-- Filter Section -->
      <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
        <div class="card-body">
          <h6 class="fw-semibold text-primary mb-3"><i class="bi bi-funnel me-2"></i>Filter Data Pelamar</h6>
          <div class="row g-3 align-items-center">
            <div class="col-12 col-md-6 col-lg-3">
              <input type="text" id="searchName" class="form-control" placeholder="Cari nama pelamar...">
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <select id="filterDivision" class="form-select">
                <option value="">Semua Divisi</option>
              </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <select id="filterPosition" class="form-select">
                <option value="">Semua Posisi</option>
              </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <select id="filterStatus" class="form-select">
                <option value="">Semua Status</option>
                <option value="Diproses">Diproses</option>
                <option value="Diterima">Diterima</option>
                <option value="Ditolak">Ditolak</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="card shadow-sm border-0" data-aos="fade-up" data-aos-delay="100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h6 class="fw-semibold text-primary mb-2 mb-lg-0">
              <i class="bi bi-people me-2"></i>Daftar Pelamar
            </h6>
            <select id="rowsPerPage" class="form-select form-select-sm w-auto">
              <option value="5">5 per halaman</option>
              <option value="10" selected>10 per halaman</option>
              <option value="20">20 per halaman</option>
            </select>
          </div>

          <div class="table-responsive">
            <table class="table align-middle table-hover" id="applicantTable">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Divisi</th>
                  <th>Posisi</th>
                  <th>Status</th>
                  <th>Tanggal Daftar</th>
                  <th>Dokumen</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="text-center text-muted small mt-5 mb-3">
        © 2025 Biro Umum dan Pengadaan Barang dan Jasa — Dashboard Admin Magang
      </footer>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">
            <i class="bi bi-person-lines-fill me-2"></i>Detail Pelamar
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="detailContent"></div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="assets-admin/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="assets-admin/js/admin-applicants.js"></script>
</body>
</html>