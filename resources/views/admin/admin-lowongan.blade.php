<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - Kelola Lowongan</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="assets-admin/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- AOS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="assets-admin/css/admin-lowongan.css">
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
        <li class="nav-item"><a href="/data-pelamar" class="nav-link"><i class="bi bi-people me-2"></i><span class="sidebar-text">Data Pelamar</span></a></li>
        <li class="nav-item"><a href="/lowongan" class="nav-link active"><i class="bi bi-list-task me-2"></i><span class="sidebar-text">Lowongan</span></a></li>
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
        <span class="fw-semibold text-primary">Kelola Lowongan Magang</span>
        <button id="btnAdd" class="btn btn-primary btn-sm ms-auto"><i class="bi bi-plus-circle me-1"></i> Tambah Lowongan</button>
    </nav>
    
    <div class="container my-5">
        <div class="card shadow-sm border-0 mb-4" data-aos="fade-up">
            <div class="card-body">
                <h6 class="fw-semibold text-primary mb-3"><i class="bi bi-briefcase me-2"></i>Daftar Lowongan</h6>
                
                <div class="table-responsive"><table class="table table-hover align-middle" id="jobTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Divisi</th>
                            <th>Tingkat</th>
                            <th>Kuota</th>
                            <th>Batas Pendaftaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <footer class="text-center text-muted small mt-5">
        © 2025 Biro Umum dan Pengadaan Barang dan Jasa — Dashboard Admin Magang
    </footer>
</div>
</div>

<!-- Modal Tambah/Edit Lowongan -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title"><i class="bi bi-briefcase me-2"></i><span id="modalTitle">Tambah Lowongan</span></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="jobForm" class="row g-3">
                    <input type="hidden" id="jobId" name="jobId">
                    <div class="col-md-6">
                        <label class="form-label">Judul Lowongan</label>
                        <input type="text" id="jobTitle" name="jobTitle" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Divisi</label>
                        <input type="text" id="jobDivision" name="jobDivision" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kuota</label>
                        <input type="number" id="jobQuota" name="jobQuota" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tingkat Pendidikan</label>
                        <input type="text" id="jobLevel" name="jobLevel" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Batas Pendaftaran</label>
                        <input type="date" id="jobDeadline" name="jobDeadline" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea id="jobDesc" name="jobDesc" rows="3" class="form-control" required></textarea>
                    </div>
                </form>
            </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button id="saveJobBtn" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</div>
</div>

<!-- Scripts -->
<script src="assets-admin/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js'"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="assets-admin/js/admin-lowongan.js"></script>
</body>
</html>