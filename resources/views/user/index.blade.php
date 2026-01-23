<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Program Magang - Biro Umum dan Pengadaan Barang dan Jasa</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets-user/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets-user/css/style.css">
</head>

<body>

  <!-- ===== HEADER ===== -->
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

  <!-- ===== HERO SECTION ===== -->
  <section class="hero-section text-center text-white d-flex align-items-center justify-content-center py-5">
    <div class="container" data-aos="fade-up">
      
      <!-- Judul Website -->
      <h2 class="fw-bold mb-3 display-5">
        <i class="bi bi-briefcase-fill me-2"></i> 
        Bangun Pengalaman Nyata Melalui Program Magang
      </h2>
      
      <!-- Uraian Magang -->
      <p class="lead mb-4">
        Dapatkan pengalaman langsung bekerja di lingkungan profesional pemerintahan, 
        bersama mentor yang siap membimbing kariermu menuju masa depan cerah.
      </p>
      
      <!-- Gambar ilustrasi Kerja Magang -->
      <div class="mt-5" data-aos="zoom-in" data-aos-delay="300">
        <img src="assets-user\images\ilustrasi-magang.jpg" alt="Ilustrasi Magang" class="hero-img" width="300">
      </div>
    </div>
  </section>

  <!-- ===== INFORMASI PROGRAM ===== -->
  <section class="container py-5">
    <div class="text-center mb-4">
      <h3 class="fw-bold text-primary">Tentang Program Magang</h3>
      <p class="text-muted">
        Program Magang di Biro Umum dan PBJ membuka peluang bagi mahasiswa aktif maupun freshgraduate dari berbagai jurusan untuk mengenal lebih dekat
        sistem administrasi, pengadaan barang/jasa, serta digitalisasi pelayanan publik.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-right">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-building fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Lingkungan Profesional</h5>
          <p class="text-muted small">Belajar langsung dalam atmosfer kerja instansi pemerintah yang dinamis dan berintegritas.</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="zoom-in">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-people fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Mentoring & Kolaborasi</h5>
          <p class="text-muted small">Dibimbing oleh pegawai profesional dan berkolaborasi dengan rekan magang dari berbagai universitas.</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-left">
        <div class="card shadow-sm border-0 h-100 hover-card text-center p-3">
          <i class="bi bi-laptop fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">Digitalisasi & Inovasi</h5>
          <p class="text-muted small">Terlibat dalam implementasi sistem digitalisasi pengadaan dan pengelolaan administrasi.</p>
        </div>
      </div>
    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <button id="btnDaftar" 
      class="btn btn-primary btn-lg px-4 rounded-pill shadow"
      data-bs-toggle="modal"
      data-bs-target="#modalFollow">
        <i class="bi bi-pencil-square me-2"></i> Daftar Magang
      </button>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="bg-light border-top py-4 text-center text-muted">
    <small>© 2025 Biro Umum & PBJ - Kementerian Pendidikan Dasar dan Menengah</small>
  </footer>

<!-- ===== MODAL FOLLOW SOSMED ===== -->
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
            <!-- <img src="assets-user/images/ig.jpg" alt="Instagram" width="50"><br> -->
            <i class="bi bi-instagram fs-2 d-block mb-1 text-primary" alt="Instagram"></i>
            <small class="d-block text-dark">@kemendikdasmen</small>
          </a>
          <a href="https://x.com/Kemdikdasmen/" target="_blank" class="social-link">
            <!-- <img src="assets-user/images/x.jpg" alt="Twitter" width="50"><br> -->
            <i class="bi bi-twitter-x fs-2 d-block mb-1 text-dark" alt="Twitter"></i>
            <small class="d-block text-dark">@Kemdikdasmen</small>
          </a>
          <a href="https://kemendikdasmen.go.id/" target="_blank" class="social-link">
            <!-- <img src="assets-user/images/web.png" alt="Website" width="50"><br> -->
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

  <!-- Bootstrap JS -->
  <script src="assets-user/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS Animation JS -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, once: true });
  </script>
  <script>
  AOS.init({ duration: 1000, once: true });

  // Tombol "Lanjutkan"
  document.getElementById("btnLanjutkan").addEventListener("click", function () {
    const modalEl = document.getElementById("modalFollow");
    const modal = bootstrap.Modal.getInstance(modalEl);

    // Tutup modal 
    modal.hide();

    // Transisi sebelum pindah halaman
    document.body.classList.add("fade-out");
    setTimeout(() => {
      window.location.href = "/joblist"; // ke halaman berikutnya
    }, 600); // waktu transisi 0.6s ada di style.css
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

  // Solusi alternatif (hanya untuk browser yang masih mendukung performance.navigation)
  /*
  if (window.performance && window.performance.navigation.type === 2) {
      window.location.reload(true);
  }
  */
</script>
  <!-- Custom JS -->
  <script src="assets-user/js/magang.js"></script>
</body>
</html>