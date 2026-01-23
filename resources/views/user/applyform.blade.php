<!-- applyform.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0"> 
    <title>Formulir Lamaran Magang - Biro Umum dan Pengadaan Barang dan Jasa</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets-user/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets-user/css/applyform.css">
</head>

<body>
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Formulir Pendaftaran Magang</h5>
            <a href="/joblist" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Lowongan</a>
        </div>
    </header>
    
    <main class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-4 fw-semibold text-primary">Isi Data Diri dan Dokumen</h5>
                <form method="POST" action="{{ route('apply.submit') }}" id="applyForm" enctype="multipart/form-data" >
                @csrf
                    <!-- Data pribadi -->
                    <h6 class="mb-3 text-secondary">Data Pribadi</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIM / No. Induk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nim" name="nim" required inputmode="numeric" pattern="[0-9]{8,15}" title="NIM/No. Induk harus berupa angka dengan panjang antara 8 hingga 15 digit."> 
                            <div class="invalid-feedback">
                                NIM/No. Induk harus berupa angka dengan panjang antara 8 hingga 15 digit.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Universitas / Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="univ" name="univ" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi / Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Aktif <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required title="Masukkan email yang valid">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon / WA <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="telepon" name="telepon" required pattern="[0-9]{10,15}"  title="Masukkan nomor telepon yang valid (hanya angka, 10-15 digit)">
                        </div>
                    </div>
                    
                    <!-- Informasi magang -->
                    <h6 class="mb-3 text-secondary">Informasi Magang</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Posisi yang Dilamar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="posisi" name="posisi" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departemen Tujuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="departemen" name="departemen" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Periode Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="mulai" name="mulai" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Periode Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="selesai" name="selesai" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Durasi (bulan) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="durasi" name="durasi" min="3" max="12" required readonly>
                            <div class="invalid-feedback">
                                Durasi magang minimal 3 bulan dan maksimal 12 bulan.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dokumen upload -->
                    <h6 class="mb-3 text-secondary">Upload Dokumen Pendukung</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Curriculum Vitae (CV) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                            <small class="form-text text-muted">Format yang diterima: PDF. Ukuran Maksimal: 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Surat Pengantar / Rekomendasi Kampus <span class="text-danger">(Wajib untuk Mahasiswa)</span></label>
                            <input type="file" class="form-control" id="surat" name="surat" accept=".pdf">
                            <small class="form-text text-muted">Format yang diterima: PDF. Ukuran Maksimal: 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Transkrip Nilai <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="transkrip" name="transkrip" accept=".pdf" required>
                            <small class="form-text text-muted">Format yang diterima: PDF. Ukuran Maksimal: 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">KTP / Kartu Identitas <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="form-text text-muted">Format yang diterima: PDF, PNG, JPG, JPEG. Ukuran Maksimal: 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pas Foto (3x4) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png" required>
                            <small class="form-text text-muted">Format yang diterima: PNG, JPG, JPEG. Ukuran Maksimal: 2MB</small>
                            <div class="invalid-feedback" id="foto-feedback">
                                Rasio foto harus 3x4. Silakan unggah ulang.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">KTM / Kartu Tanda Mahasiswa <span class="text-danger">(Wajib untuk Mahasiswa)</span></label>
                            <input type="file" class="form-control" id="ktm" name="ktm" accept=".jpg,.jpeg,.png">
                            <small class="form-text text-muted">Format yang diterima: PNG, JPG, JPEG. Ukuran Maksimal: 2MB</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Link Portofolio (Opsional)</label>
                            <input type="url" class="form-control" id="link" name="link">
                        </div>
                    </div>
					<input type="hidden" name="lowongan_id" id="inputLowonganId" value="">
                    
                    <!-- Tombol -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <!-- Modal sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                <h5>Lamaran Berhasil Dikirim!</h5>
                <p class="text-muted small mb-3">Terima kasih sudah mengirimkan lamaran magang. Kami akan menghubungi Anda melalui email jika lolos tahap seleksi administrasi.</p>
                <div class="d-grid">
                    <a href="/joblist" class="btn btn-primary">Kembali ke Daftar Lowongan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Reset -->
    <div class="modal fade" id="confirmResetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 12px;">
            
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
            
                <h5 class="fw-bold mb-2">Batalkan Lamaran?</h5>
                <p class="text-muted small mb-4">
                    Apakah Anda yakin ingin membatalkan proses lamaran? Semua data yang sudah diisi akan hilang.
                </p>
            
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tidak</button>
                    <button id="confirmYesBtn" type="button" class="btn btn-danger px-4">Ya, Batalkan</button>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="text-center py-3 text-muted small">
        © 2025 Biro Umum & PBJ — Formulir Pendaftaran Magang
    </footer>
    
    <script src="assets-user/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
    <script src="assets-user/js/applyform.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    
    // 1. Efek Fade-in Halaman
    requestAnimationFrame(() => {
        document.body.classList.add("fade-in");
    });

    // 2. Mengisi Data Form Otomatis dari LocalStorage
    // Ambil data yang disimpan saat klik tombol 'Detail' di halaman sebelumnya
    const id = localStorage.getItem("lowonganId");
    const posisi = localStorage.getItem("posisiDilamar");
    const dept = localStorage.getItem("departemenTujuan");

    // Masukkan ke input field jika elemennya ada
    const inputId = document.getElementById("inputLowonganId");
    const inputPosisi = document.getElementById("posisi");
    const inputDept = document.getElementById("departemen");

    if (id && inputId) inputId.value = id;
    if (posisi && inputPosisi) inputPosisi.value = posisi;
    if (dept && inputDept) inputDept.value = dept;

    // 3. Logika Tombol Reset / Batal
    const resetBtn = document.querySelector('button[type="reset"]');
    const confirmModalEl = document.getElementById("confirmResetModal");
    
    // Cek apakah elemen modal dan tombol ada untuk mencegah error
    if (resetBtn && confirmModalEl) {
        const confirmModal = new bootstrap.Modal(confirmModalEl);
        const confirmYesBtn = document.getElementById("confirmYesBtn");

        resetBtn.addEventListener("click", (e) => {
            e.preventDefault();
            confirmModal.show();
        });

        confirmYesBtn.addEventListener("click", () => {
            confirmModal.hide();
            // Efek transisi keluar
            document.body.style.transition = "opacity 0.5s ease";
            document.body.style.opacity = 0;

            setTimeout(() => {
                // Kembali ke halaman list lowongan
                window.location.href = "/joblist"; 
            }, 500);
        });
    }
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Cek session success dari Laravel Controller
        @if(session('success'))
            var successModalEl = document.getElementById('successModal');
            if(successModalEl){
                var successModal = new bootstrap.Modal(successModalEl);
                successModal.show();
            }
        @endif
    });
</script>

<script>
    window.addEventListener('pageshow', function (event) {
        // Jika halaman dimuat dari cache (misal user tekan tombol back), paksa reload
        // agar form reset dan data fresh.
        if (event.persisted) {
            console.log('Reloading from BFCache...');
            window.location.reload(); 
        }
    });
</script>
</body>
</html>