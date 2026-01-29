<!-- joblist.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0"> 
    <title>Daftar Lowongan Magang - Biro Umum dan Pengadaan Barang dan Jasa</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets-user/images/logo.png') }}">  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets-user/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets-user/css/joblist.css') }}?v={{ time() }}">
</head>
<body>
    
    <!-- Header -->
    <header class="bg-primary text-white py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="assets-user/images/logo.png" alt="Logo" class="logo" style="height:44px;">
                <div>
                    <a href="/" style="text-decoration: none; color: inherit;">
                        <h5 class="fw-semibold mb-0">Biro Umum dan PBJ</h5>
                        <small>Program Magang Instansi Pemerintah</small>
                    </a>
                </div>
            </div>
            <a href="/" class="btn btn-outline-light btn-sm"> <i class="bi bi-arrow-left"></i> Kembali ke Program Magang</a>
        </div>
    </header>
    
    <!-- Main -->
    <main class="container my-5">
        <div class="row g-4">
            <!-- Sidebar filter -->
            <aside class="col-lg-3">
                <div class="card shadow-sm p-3 sticky-top" style="top:1rem;">
                    <h6 class="mb-3">Filter & Pencarian</h6>
                    <div class="mb-3">
                        <label class="form-label small">Cari kata kunci</label>
                        <input id="qSearch" class="form-control form-control-sm" placeholder="mis. Administrasi, IT, Keuangan">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Substansi</label>
                        <select id="filterDept" class="form-select form-select-sm">
                            <option value="">Semua</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Jenjang Pendidikan</label>
                        <select id="filterLevel" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option>SMA/SMK</option>
                            <option>D3</option>
                            <option>D4</option>
                            <option>S1</option>
                        </select>
                    </div>
                    
                    <div class="mb-2 d-grid">
                        <button id="btnReset" class="btn btn-outline-primary btn-sm">Reset Filter</button>
                    </div>
                    
                    <hr>
                    <h6 class="mb-2">Sort</h6>
                    <div class="d-flex gap-2">
                        <select id="sortBy" class="form-select form-select-sm">
                            <option value="recent">Terbaru</option>
                            <option value="deadline">Tenggat Terdekat</option>
                            <option value="title">Judul A→Z</option>
                        </select>
                    </div>
                </div>
            </aside>
            
            <!-- List & controls -->
            <section class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                    <div>
                        <strong id="resultCount">0</strong> lowongan ditemukan
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="small mb-0 me-1">Tampilan</label>
                        <div class="btn-group" role="group">
                            <button id="gridViewBtn" class="btn btn-sm btn-outline-secondary active" title="Grid"><i class="bi bi-grid-3x3-gap"></i></button>
                            <button id="listViewBtn" class="btn btn-sm btn-outline-secondary" title="List"><i class="bi bi-list-ul"></i></button>
                        </div>
                    </div>
                </div>
                
                <!-- container untuk cards -->
                <div id="jobsContainer" class="row g-3"></div>
                
                <!-- Pagination -->
                <nav class="mt-4" aria-label="Pagination">
                    <ul id="pagination" class="pagination pagination-sm"></ul>
                </nav>
            </section>
        </div>
    </main>
    
    <!-- Modal Detail & Apply -->
    <div class="modal fade" id="jobModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                
                <div class="modal-header bg-primary text-white">
                    <h5 id="jobModalTitle" class="modal-title fw-semibold"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body pb-4">
                    <p id="jobModalBody" class="text-muted mb-3"></p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-2 small text-secondary">
                        <span class="bg-light px-2 py-1 rounded border"><i class="bi bi-building me-1"></i> <span id="jobDept"></span></span>
                        <span class="bg-light px-2 py-1 rounded border"><i class="bi bi-calendar-event me-1"></i> Tenggat: <span id="jobDeadline"></span></span>
                    </div>

                    <div class="section-title-line">
                        👇 Pilih Jalur Pendaftaran Sesuai Jenjang Pendidikan Anda Saat Ini:
                    </div>

                    <div class="row g-3">
                        
                        <div class="col-md-4">
                            <div class="edu-card" id="card-sma">
                                <span class="edu-badge badge-sma">Siswa SMK/SMA</span>
                                <small class="status-text" id="status-sma">(Status: Aktif)</small>
                                
                                <div class="text-center mb-2 text-primary small fw-bold" id="quota-box-sma">
                                    <i class="bi bi-people-fill"></i> Kuota: <span id="quota-sma"></span>
                                </div>

                                <div class="edu-content" id="content-sma">
                                    <strong>Jurusan:</strong>
                                    <ul id="list-sma"></ul> 
                                </div>

                                <div class="lock-icon" id="lock-sma" style="display:none;">
                                    <i class="bi bi-lock-fill"></i>
                                    <div style="font-size:0.7rem; margin-top:5px;">Tidak dibuka untuk jenjang ini</div>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-primary btn-sm w-100 btn-apply-track" id="btn-sma" data-level="SMA/SMK">
                                        Daftar Jalur SMA/SMK
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="edu-card" id="card-d3">
                                <span class="edu-badge badge-d3">Mahasiswa D3</span>
                                <small class="status-text" id="status-d3">(Status: Aktif)</small>
                                
                                <div class="text-center mb-2 text-success small fw-bold" id="quota-box-d3">
                                    <i class="bi bi-people-fill"></i> Kuota: <span id="quota-d3"></span>
                                </div>

                                <div class="edu-content" id="content-d3">
                                    <strong>Jurusan:</strong>
                                    <ul id="list-d3"></ul>
                                </div>

                                <div class="lock-icon" id="lock-d3" style="display:none;">
                                    <i class="bi bi-lock-fill"></i>
                                    <div style="font-size:0.7rem; margin-top:5px;">Tidak dibuka untuk jenjang ini</div>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-primary btn-sm w-100 btn-apply-track" id="btn-d3" data-level="D3">
                                        Daftar Jalur D3
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="edu-card" id="card-s1">
                                <span class="edu-badge badge-s1">Mahasiswa D4/S1</span>
                                <small class="status-text" id="status-s1">(Status: Aktif)</small>
                                
                                <div class="text-center mb-2 text-danger small fw-bold" id="quota-box-s1">
                                    <i class="bi bi-people-fill"></i> Kuota: <span id="quota-s1"></span>
                                </div>

                                <div class="edu-content" id="content-s1">
                                    <strong>Jurusan:</strong>
                                    <ul id="list-s1"></ul>
                                </div>

                                <div class="lock-icon" id="lock-s1" style="display:none;">
                                    <i class="bi bi-lock-fill"></i>
                                    <div style="font-size:0.7rem; margin-top:5px;">Tidak dibuka untuk jenjang ini</div>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-primary btn-sm w-100 btn-apply-track" id="btn-s1" data-level="S1/D4">
                                        Daftar Jalur D4/S1
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div> 
                </div>

                <div class="modal-footer modal-footer-custom bg-white">
                    <button class="btn btn-outline-secondary px-4 w-100" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 text-muted small">
        © 2025 Biro Umum & PBJ — Halaman daftar lowongan magang
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets-user/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}" ></script>
    <!-- Custom JS -->
    <script>
        // Data lowongan dari Controller dikirimkan ke JavaScript global
        window.lowonganData = @json($lowongans);
    </script>
    <script src="{{ asset('assets-user/js/joblist.js') }}?v={{ time() }}"></script>
    <!-- Custom Page Transition -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    // ada kelas fade-in ketika halaman selesai dimuat
    requestAnimationFrame(() => {
        document.body.classList.add("fade-in");
    });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const applyBtn = document.getElementById("applyBtn");
        if (applyBtn) {
            applyBtn.addEventListener("click", () => {
          // Tambahkan efek transisi sebelum pindah halaman
        document.body.style.transition = "opacity 0.5s ease";
        document.body.style.opacity = 0;
    
        setTimeout(() => {
            // Arahkan ke halaman applyform
            window.location.href = "/applyform";
        }, 500);
        });
    }
    });
</script>
<script>
  // Menggunakan event 'pageshow' yang mendeteksi pemuatan dari BFCache
  window.addEventListener('pageshow', function (event) {
    // Properti 'persisted' bernilai true jika halaman dimuat dari BFCache.
    // Jika itu true, maka kita harus memuat ulang secara paksa.
    if (event.persisted) {
      console.log('Halaman dimuat dari BFCache. Memaksa refresh...');
      
      // Menggunakan location.href, yang terkadang lebih efektif daripada location.reload()
      // untuk memutus BFCache di beberapa browser lama, meski seharusnya reload() cukup.
      window.location.reload(); 
    }
  });
</script>

</body>
</html>