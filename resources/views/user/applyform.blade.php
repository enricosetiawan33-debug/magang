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
    <link rel="icon" type="image/x-icon" href="{{ asset('assets-user/images/logo.png') }}">
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
            <div class="container mt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="manualAlert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Status:</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-4 fw-semibold text-primary">Isi Data Diri dan Dokumen</h5>
                <form method="POST" action="{{ route('apply.submit') }}" id="applyForm" enctype="multipart/form-data" >
                @csrf
                    <input type="hidden" id="lowongan_id" name="lowongan_id">
                    <!-- Data pribadi -->
                    <h6 class="mb-3 text-secondary">Data Pribadi</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIM / NISN <span class="text-danger">*</span></label>
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
                        <div class="d-flex align-items-center mb-2">
                            <label class="form-label mb-0 me-2" for="telepon">
                                No. Telepon Whatsapp <span class="text-danger">*</span>
                            </label>
                            
                            <a tabindex="0" 
                            class="btn btn-sm btn-outline-info rounded-pill py-0 px-2" 
                            role="button" 
                            data-bs-toggle="popover" 
                            data-bs-trigger="focus" 
                            data-bs-html="true"
                            title="<i class='bi bi-whatsapp text-success'></i> Informasi Kontak"
                            data-bs-content="
                            <div class='mb-2 small'>
                                <span class='text-danger fw-bold'><i class='bi bi-exclamation-circle-fill'></i> Penting:</span>
                                Pastikan nomor ini <b>terhubung dengan WhatsApp</b>.
                            </div>
                            <p class='mb-2 small'>Kami akan mengirimkan <b>Pengumuman Seleksi</b> melalui nomor ini.</p>
                            <div class='p-2 bg-light rounded border border-light'>
                                <small class='text-muted d-block'>Official Contact Center:</small>
                                <strong class='text-dark'><i class='bi bi-shield-check text-primary'></i> 0812-XXXX-XXXX</strong>
                            </div>
                            ">
                            <i class="bi bi-info-circle-fill"></i> Info Penting
                            </a>
                        </div>

                        <input type="tel" class="form-control" id="telepon" name="telepon" required pattern="[0-9]{10,15}" title="Masukkan nomor telepon yang valid (hanya angka, 10-15 digit)">
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
                            <input type="number" class="form-control" id="durasi" name="durasi" required readonly>
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
                            <label class="form-label">Surat Pengantar / Rekomendasi Kampus <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="surat" name="surat" accept=".pdf" required>
                            <small class="form-text text-muted">Format yang diterima: PDF. Ukuran Maksimal: 2MB</small>
                        </div>
                        <!-- <div class="col-md-6">
                            <label class="form-label">Transkrip Nilai <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="transkrip" name="transkrip" accept=".pdf" required>
                            <small class="form-text text-muted">Format yang diterima: PDF. Ukuran Maksimal: 2MB</small>
                        </div> -->
                        <div class="col-md-6">
                            <label class="form-label">KTP / Kartu Identitas (Opsional)</label>
                            <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf,.jpg,.jpeg,.png">
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
                        <div class="col-md-6">
                            <label class="form-label">Link Portofolio (Opsional)</label>
                            <input type="url" class="form-control" id="link" name="link">
                        </div>
                    </div>
                    
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

    <!-- Modal Consent (Persetujuan User)  -->
    <div class="modal fade" id="consentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold text-primary">
                        <i class="bi bi-shield-lock-fill me-2"></i>Persetujuan Penggunaan Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 d-flex align-items-center mb-3">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        <small>Sebelum melanjutkan, mohon baca dan setujui ketentuan privasi data berikut.</small>
                    </div>
                    
                    <div class="terms-scroll-box border rounded p-3 bg-white mb-3" style="max-height: 250px; overflow-y: auto;">
                        <h6 class="fw-bold">1. Pengumpulan Data</h6>
                        <p class="small text-muted mb-2">
                            Dengan mengirimkan formulir ini, Anda memberikan izin kepada <strong>Biro Umum & PBJ</strong> untuk mengumpulkan, menyimpan, dan memproses data pribadi Anda (termasuk Nama, NIM, No. Telepon, dan Dokumen Pendukung) semata-mata untuk keperluan <strong>Seleksi Program Magang</strong>.
                        </p>

                        <h6 class="fw-bold">2. Keamanan Data</h6>
                        <p class="small text-muted mb-2">
                            Kami berkomitmen menjaga kerahasiaan data Anda. Data tidak akan disebarluaskan, dijual, atau diberikan kepada pihak ketiga di luar keperluan administrasi internal kementerian.
                        </p>

                        <h6 class="fw-bold">3. Verifikasi & Integritas</h6>
                        <p class="small text-muted mb-2">
                            Anda menyatakan bahwa seluruh dokumen dan informasi yang diunggah adalah <strong>benar, asli, dan dapat dipertanggungjawabkan</strong>. Pemalsuan dokumen dapat mengakibatkan diskualifikasi atau sanksi sesuai ketentuan yang berlaku.
                        </p>

                        <h6 class="fw-bold">4. Komunikasi</h6>
                        <p class="small text-muted mb-0">
                            Anda menyetujui untuk dihubungi melalui WhatsApp atau Email yang terdaftar terkait proses seleksi dan wawancara.
                        </p>
                    </div>

                    <div class="p-3 bg-light rounded border d-flex justify-content-between align-items-center mt-3">
                    <label class="form-check-label small user-select-none me-3" for="agreeCheck" style="cursor: pointer;">
                        Saya telah membaca, memahami, dan <strong>menyetujui</strong> seluruh ketentuan di atas serta menyatakan data yang saya isi adalah benar.
                    </label>
                    
                    <input class="form-check-input m-0" type="checkbox" id="agreeCheck" 
                        style="width: 1.5em; height: 1.5em; cursor: pointer; border-color: #0d6efd;">
                </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary px-4 disabled-btn" id="btnFinalSubmit" disabled>
                        <i class="bi bi-send-fill me-2"></i>Kirim Lamaran
                    </button>
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
    // Animasi Fade In
    document.addEventListener("DOMContentLoaded", () => {
        requestAnimationFrame(() => {
            document.body.classList.add("fade-in");
        });
    });

    // === LOGIKA MODAL SUKSES (HYBRID SESSION + LOCALSTORAGE) ===
    document.addEventListener("DOMContentLoaded", function() {
        
        var modalEl = document.getElementById('successModal');
        
        // Cek 1: Apakah ada session dari Laravel? (Cara normal)
        var hasSession = @json(session('success') ? true : false);
        
        // Cek 2: Apakah ada bendera di LocalStorage? (Cara backup jika redirect error)
        var hasLocalFlag = localStorage.getItem('lamaran_berhasil_dikirim');

        if (modalEl && (hasSession || hasLocalFlag)) {
            // Tampilkan Modal
            var myModal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();

            // PENTING: Hapus bendera LocalStorage agar modal tidak muncul terus saat refresh
            localStorage.removeItem('lamaran_berhasil_dikirim');
        }
    });

    // Fix untuk tombol Back browser (BFCache)
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload(); 
        }
    });
</script>
</body>
</html>