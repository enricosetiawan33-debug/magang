<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Program Magang - Biro Umum dan Pengadaan Barang dan Jasa</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets-user/images/logo.png') }}">
  <link rel="stylesheet" href="assets-user/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <link rel="stylesheet" href="assets-user/css/style.css">
</head>

<body>

  <header class="header-gradient text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <a href="/">
          <img src="assets-user/images/logo.png" alt="Logo" class="logo me-3" href="/">
        </a>
        <div>
          <a href="/" style="text-decoration: none; color: inherit;">
            <h5 class="fw-semibold mb-0">Biro Umum dan PBJ</h5>
            <small>Program Magang Instansi Pemerintah</small>
          </a>
        </div>
      </div>
      <a href="https://biroumumpbj.kemendikdasmen.go.id/view/" class="btn btn-outline-light rounded-pill px-3"> <i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </header>

  <section class="hero-section text-center text-white d-flex align-items-center justify-content-center py-5">
    <div class="container" data-aos="fade-up">
      
      <h2 class="fw-bold mb-3 display-5">
        <i class="bi bi-briefcase-fill me-2"></i> 
        Wujudkan Potensi, Berkontribusi Nyata untuk Negeri.
      </h2>
      
      <p class="lead mb-4">
      Lengkapi portofoliomu dengan pengalaman magang di instansi pusat. Dari kemampuan teknis, pemecahan masalah, hingga kolaborasi tim—asah kemampuanmu bersama para ahli.
      </p>
      
      <div class="mt-5" data-aos="zoom-in" data-aos-delay="300">
        <img src="assets-user\images\ilustrasi-magang.jpg" alt="Ilustrasi Magang" class="hero-img" width="300">
      </div>
    </div>
  </section>

  <section class="container py-5">
    <div class="text-center mb-4">
      <h3 class="fw-bold text-primary">Boost Kariermu Sejak Dini</h3>
      <p class="text-muted">
      Jembatani teori di kelas dengan praktik di lapangan. Program ini dirancang khusus bagi pelajar dan mahasiswa untuk terlibat langsung dalam operasional instansi pemerintah, mulai dari manajemen administrasi hingga transformasi digital pelayanan publik.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-right">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-building fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Real World Experience</h5>
          <p class="text-muted small">Hadapi tantangan nyata dunia kerja, bukan sekadar tugas simulasi kuliah.</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="zoom-in">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-people fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Networking & Bimbingan</h5>
          <p class="text-muted small">Perluas koneksi profesionalmu dan dapatkan ilmu praktis dari praktisi senior.</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-left">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-laptop fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Inovasi Tanpa Batas</h5>
          <p class="text-muted small">Salurkan ide kreatifmu untuk mengembangkan teknologi dan sistem di Biro Umum.</p>
        </div>
      </div>
    </div>

    <div class="mt-5 pt-4">
      
      <div class="text-center mb-5" data-aos="fade-up">
        <h3 class="fw-bold text-primary">Posisi yang Sedang Hiring</h3>
        <p class="text-muted">
        Pilih tantanganmu hari ini. Tersedia untuk berbagai jurusan dan jenjang pendidikan.
        </p>
      </div>

      <div class="row g-4"> 
        
        @forelse($recentJobs as $index => $job)
          @php
              // 1. Logika Warna Badge Header
              $themes = ['primary', 'success', 'warning'];
              $theme = $themes[$index % 3];
              $bgClass = 'bg-soft-' . $theme;
              $textClass = 'text-' . $theme;

              // 2. Logika Parsing Requirements (Jurusan) YANG DIPERBAIKI
              $rawReqs = $job->requirements ?? ''; 
              $jurusanList = [];

              // Normalisasi baris baru (mengantisipasi input dari textarea)
              $rawReqs = str_replace(["\r\n", "\r"], "\n", $rawReqs);

              // Cek pola pemisah yang digunakan user di database
              if (str_contains($rawReqs, "\n")) {
                  // Jika ada Enter/Baris baru, pisahkan berdasarkan baris
                  $jurusanList = explode("\n", $rawReqs);
              } 
              elseif (str_contains($rawReqs, '•')) {
                  // Jika menggunakan bullet points (•)
                  $jurusanList = explode('•', $rawReqs);
              } 
              elseif (str_contains($rawReqs, ',')) {
                  // Jika menggunakan koma
                  $jurusanList = explode(',', $rawReqs);
              } 
              else {
                  // Fallback: Coba pisahkan berdasarkan strip "-" jika ada banyak
                  // Asumsi format: "- Jurusan A - Jurusan B"
                  $parts = explode('-', $rawReqs);
                  // Filter hasil yang kosong (biasanya elemen pertama sebelum strip pertama)
                  $jurusanList = array_filter($parts, fn($value) => trim($value) !== '');
              }

              // Bersihkan sisa karakter aneh di setiap item hasil pecahan
              $jurusanList = array_map(function($item) {
                  return trim(str_replace(['[', ']', '"', '•', '- '], '', $item));
              }, $jurusanList);

              // Hapus elemen array yang kosong atau null
              $jurusanList = array_filter($jurusanList, fn($value) => !empty($value));
              
              // Ambil maksimal 4 jurusan saja agar kartu rapi
              $jurusanList = array_slice($jurusanList, 0, 4);
          @endphp

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
            <div class="card h-100 border-0 shadow-sm p-3 job-card d-flex flex-column">
              
              <div class="d-flex justify-content-between mb-3">
                <span class="badge {{ $bgClass }} {{ $textClass }} rounded-pill">
                    {{ $job->division ?? 'Umum' }}
                </span>
                <small class="text-muted"><i class="bi bi-clock"></i> WFO</small>
              </div>

              <h6 class="fw-bold mb-1">{{ $job->title }}</h6>
              
              <p class="text-muted small mb-3">
                  {{ Str::limit($job->description, 80) }}
              </p>
              
              <div class="mt-auto d-flex gap-2 badge-scroll-container">
                @if(count($jurusanList) > 0)
                    @foreach($jurusanList as $jurusan)
                        <span class="badge bg-light text-secondary border fw-normal">
                            {{ $jurusan }}
                        </span>
                    @endforeach
                @else
                    <span class="badge bg-light text-secondary border fw-normal">
                        {{ is_array($job->level) ? implode(', ', $job->level) : $job->level }}
                    </span>
                @endif
              </div>
              
              <hr class="my-3 border-light">
              
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center text-muted small">
                  <i class="bi bi-geo-alt-fill me-1 text-danger"></i> Jakarta
                </div>
                <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail</a>
              </div>
            </div>
          </div>

        @empty
          <div class="col-12 text-center py-5">
              <div class="alert alert-light border shadow-sm d-inline-block px-5">
                  <i class="bi bi-info-circle me-2"></i> Belum ada lowongan yang dibuka saat ini.
              </div>
          </div>
        @endforelse

      </div> </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <button id="btnDaftar" 
      class="btn btn-primary btn-lg px-4 rounded-pill shadow"
      data-bs-toggle="modal"
      data-bs-target="#modalFollow">
        <i class="bi bi-pencil-square me-2"></i> Daftar Magang
      </button>
    </div>
  </section>

  <footer class="bg-light border-top py-4 text-center text-muted">
    <small>© 2025 Biro Umum & PBJ - Kementerian Pendidikan Dasar dan Menengah</small>
  </footer>

<div class="modal fade" id="modalFollow" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header-custom bg-primary text-white p-3 rounded-top d-flex justify-content-between align-items-center">
        <h5 class="modal-title">
          <i class="bi bi-stars me-2"></i>Ikuti Akun Resmi Kami
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-muted mb-4">
          Dukung kami dengan mengikuti akun resmi instansi untuk mendapatkan informasi magang terbaru!
        </p>
        <div class="d-flex justify-content-around gap-2 mb-4 px-5">
          <a href="https://www.instagram.com/kemendikdasmen/" target="_blank" class="social-link">
            <i class="bi bi-instagram fs-2 d-block mb-1 text-primary" alt="Instagram"></i>
            <small class="d-block text-dark">@kemendikdasmen</small>
          </a>
          <a href="https://x.com/Kemdikdasmen/" target="_blank" class="social-link">
            <i class="bi bi-twitter-x fs-2 d-block mb-1 text-dark" alt="Twitter"></i>
            <small class="d-block text-dark">@Kemdikdasmen</small>
          </a>
          <a href="https://kemendikdasmen.go.id/" target="_blank" class="social-link">
            <i class="bi bi-globe fs-2 d-block mb-1 text-success" alt="Website"></i>
            <small class="d-block text-dark">Website</small>
          </a>
        </div>
      </div>
      <div class="modal-footer-custom p-0">
          <button id="btnLanjutkan" class="btn btn-primary w-100 py-3 rounded-0 border-0">
          <i class="bi bi-arrow-right-circle me-2"></i> Lanjutkan
        </button>
      </div>
    </div>
  </div>
</div>

  <script src="assets-user/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  
  <script>
    // Init AOS
    document.addEventListener("DOMContentLoaded", () => {
        AOS.init({ duration: 1000, once: true });
        
        // Tombol Lanjutkan Logic
        const btnLanjutkan = document.getElementById("btnLanjutkan");
        if (btnLanjutkan) {
            btnLanjutkan.addEventListener("click", () => {
                const modalEl = document.getElementById("modalFollow");
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (!modal) modal = new bootstrap.Modal(modalEl);
                
                modal.hide();
                
                // Transisi fade out sebelum pindah
                setTimeout(() => {
                    document.body.classList.add("fade-out");
                    setTimeout(() => {
                        window.location.href = "/joblist";
                    }, 600);
                }, 300);
            });
        }
    });

    // Fix BFCache (Back Button issue)
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload(); 
        }
    });
  </script>
</body>
</html>