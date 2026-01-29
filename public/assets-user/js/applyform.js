document.addEventListener("DOMContentLoaded", () => {
    
    // 1. Inisialisasi Popover & Setup Parameter
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    popoverTriggerList.map(function (popoverTriggerEl) { return new bootstrap.Popover(popoverTriggerEl) });

    const urlParams = new URLSearchParams(window.location.search);
    const setInputValue = (id, paramName, storageName) => {
        const el = document.getElementById(id);
        if(!el) return;
        const val = urlParams.get(paramName) || localStorage.getItem(storageName);
        if (val) el.value = decodeURIComponent(val);
    };
    setInputValue("posisi", "posisi", "posisiDilamar");
    setInputValue("lowongan_id", "lowongan_id", "lowongan_id");
    setInputValue("departemen", "departemen", "departemenTujuan");

    const form = document.getElementById("applyForm");
    const inputFoto = document.getElementById("foto");
    const feedbackFoto = document.getElementById("foto-feedback");

    // 2. Fungsi Validasi Foto Rasio
    const validateFotoRasio = (file) => {
        return new Promise((resolve) => {
            if (!file) { resolve(true); return; }
            const img = new Image();
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                img.onload = () => {
                    const rasio = img.width / img.height;
                    resolve(rasio >= 0.70 && rasio <= 0.82);
                };
            };
            reader.readAsDataURL(file);
        });
    };

    // 3. Hitung Durasi
    const inputMulai = document.getElementById("mulai");
    const inputSelesai = document.getElementById("selesai");
    const inputDurasi = document.getElementById("durasi");

    const hitungDurasi = () => {
        if (inputMulai.value && inputSelesai.value) {
            const start = new Date(inputMulai.value);
            const end = new Date(inputSelesai.value);
            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                inputDurasi.value = Math.ceil(diffDays / 30);
            }
        }
    };
    if(inputMulai && inputSelesai) {
        inputMulai.addEventListener("change", hitungDurasi);
        inputSelesai.addEventListener("change", hitungDurasi);
    }

    // ============================================================
    // 6. VALIDASI REAL-TIME
    // ============================================================

    // A. Validasi Text
    const setupRealtimeTextValidation = (id, regex, errorMsg) => {
        const input = document.getElementById(id);
        const feedback = document.getElementById(`error-${id}`);
        
        if (input) {
            input.addEventListener('input', function() {
                const val = this.value;
                if (val === "") {
                    this.classList.remove('is-invalid', 'is-valid');
                } else if (!regex.test(val)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    if(feedback) feedback.textContent = errorMsg;
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }
    };

    setupRealtimeTextValidation('nim', /^[0-9]{8,15}$/, 'NIM/NISN harus berupa angka 8-15 digit.');
    setupRealtimeTextValidation('telepon', /^[0-9]{10,15}$/, 'Nomor WA harus berupa angka 10-15 digit.');
    setupRealtimeTextValidation('email', /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'Format email tidak valid.');

    // B. Validasi File
    const setupRealtimeFileValidation = (id, allowedExts, maxSizeMB = 2) => {
        const input = document.getElementById(id);
        const feedback = document.getElementById(`error-${id}`);

        if (input) {
            input.addEventListener('change', function() {
                const file = this.files[0];
                this.classList.remove('is-invalid', 'is-valid'); 

                if (file) {
                    if (file.size > maxSizeMB * 1024 * 1024) {
                        this.classList.add('is-invalid');
                        if(feedback) feedback.textContent = `Ukuran file terlalu besar (Maksimal ${maxSizeMB}MB).`;
                        this.value = ""; 
                        return;
                    }
                    const fileName = file.name.toLowerCase();
                    const isValidExt = allowedExts.some(ext => fileName.endsWith(ext));

                    if (!isValidExt) {
                        this.classList.add('is-invalid');
                        if(feedback) feedback.textContent = `Format file salah. Harap upload: ${allowedExts.join(', ')}`;
                        this.value = ""; 
                        return;
                    }
                    this.classList.add('is-valid');
                }
            });
        }
    };

    setupRealtimeFileValidation('cv', ['.pdf']);
    setupRealtimeFileValidation('surat', ['.pdf']);
    setupRealtimeFileValidation('ktp', ['.pdf', '.jpg', '.jpeg', '.png']);
    setupRealtimeFileValidation('ktm', ['.jpg', '.jpeg', '.png']);

    // C. Validasi Khusus Foto
    if (inputFoto) {
        inputFoto.addEventListener('change', async function() {
            const file = this.files[0];
            this.classList.remove('is-invalid', 'is-valid');

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    this.classList.add('is-invalid');
                    feedbackFoto.textContent = "Ukuran foto terlalu besar (Maksimal 2MB).";
                    this.value = "";
                    return;
                }
                const allowed = ['.jpg', '.jpeg', '.png'];
                const fileName = file.name.toLowerCase();
                if (!allowed.some(ext => fileName.endsWith(ext))) {
                    this.classList.add('is-invalid');
                    feedbackFoto.textContent = "Format foto harus JPG atau PNG.";
                    this.value = "";
                    return;
                }
                const isValidRasio = await validateFotoRasio(file);
                if (!isValidRasio) {
                    this.classList.add('is-invalid');
                    feedbackFoto.textContent = "Rasio foto tidak sesuai (Harus 3x4 Potrait).";
                } else {
                    this.classList.add('is-valid');
                }
            }
        });
    }

    // 4. Logic Tombol "Kirim Lamaran" (Validasi Awal)
    if (form) {
        form.addEventListener("submit", async (event) => {
            event.preventDefault(); 
            event.stopPropagation();
            form.classList.add('was-validated'); 

            if (!form.checkValidity()) {
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            const manualInvalid = form.querySelector('.is-invalid');
            if (manualInvalid) {
                manualInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            if (inputFoto && inputFoto.files[0]) {
                const isFotoValid = await validateFotoRasio(inputFoto.files[0]);
                if (!isFotoValid) {
                    inputFoto.classList.add('is-invalid');
                    feedbackFoto.textContent = "Rasio foto harus 3x4 (Potrait).";
                    inputFoto.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
            }

            const consentModalEl = document.getElementById('consentModal');
            if(consentModalEl) {
                const consentModal = new bootstrap.Modal(consentModalEl);
                consentModal.show();
            }
        });
    }

    // 5. Logic Tombol "Kirim Final" (BACKGROUND SUBMIT)
    const agreeCheck = document.getElementById('agreeCheck');
    const btnFinalSubmit = document.getElementById('btnFinalSubmit');
    
    // DEFINISI VARIABEL YANG MENYEBABKAN ERROR KITA PINDAHKAN KE SINI (Global Scope dalam DOMContentLoaded)
    const consentModalEl = document.getElementById('consentModal'); 

    if(agreeCheck && btnFinalSubmit){
        agreeCheck.addEventListener('change', function() {
            if (this.checked) {
                btnFinalSubmit.removeAttribute('disabled');
                btnFinalSubmit.classList.remove('disabled-btn');
            } else {
                btnFinalSubmit.setAttribute('disabled', 'true');
                btnFinalSubmit.classList.add('disabled-btn');
            }
        });

        btnFinalSubmit.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            this.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    // Header ini PENTING agar Laravel membalas error Validasi sebagai JSON
                    // bukan redirect halaman.
                    'X-Requested-With': 'XMLHttpRequest', 
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                // Cek jika respon sukses (200) atau error (422/500)
                const data = await response.json().catch(() => ({}));
                
                if (!response.ok) {
                    // Jika Error Validasi (422)
                    if (response.status === 422) {
                        let errorMsg = "Mohon periksa inputan Anda:\n";
                        if(data.errors) {
                            for (const [key, msgs] of Object.entries(data.errors)) {
                                errorMsg += `- ${msgs[0]}\n`;
                            }
                        }
                        throw new Error(errorMsg);
                    }
                    // Jika Error Server Lain
                    throw new Error(data.message || 'Terjadi kesalahan pada server.');
                }
                
                return data; // Jika sukses, lanjut ke .then berikutnya
            })
            .then(data => {
                // === SUKSES ===
                if (consentModalEl) {
                    const consentModal = bootstrap.Modal.getInstance(consentModalEl);
                    if (consentModal) consentModal.hide();
                }

                const successModalEl = document.getElementById('successModal');
                if(successModalEl){
                    const successModal = new bootstrap.Modal(successModalEl, {
                        backdrop: 'static', keyboard: false
                    });
                    successModal.show();
                }

                form.reset();
                form.classList.remove('was-validated');
                document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });

                btnFinalSubmit.setAttribute('disabled', 'true');
                btnFinalSubmit.classList.add('disabled-btn');
                agreeCheck.checked = false;
                this.innerHTML = originalText;
                
                // Isi ulang data lowongan
                setInputValue("posisi", "posisi", "posisiDilamar");
                setInputValue("lowongan_id", "lowongan_id", "lowongan_id");
                setInputValue("departemen", "departemen", "departemenTujuan");
            })
            .catch(error => {
                // === ERROR ===
                console.error('Error:', error);
                
                // Tampilkan pesan error ASLI dari Laravel
                alert(error.message); 
                
                this.innerHTML = originalText;
                this.disabled = false;
                
                if (consentModalEl) {
                    const consentModal = bootstrap.Modal.getInstance(consentModalEl);
                    if (consentModal) consentModal.hide();
                }
            });
        });
    }

    // ============================================================
    // 7. LOGIKA TOMBOL RESET (CUSTOM FIX)
    // ============================================================
    const btnReset = document.querySelector('button[type="reset"]');
    
    if (btnReset && form) {
        btnReset.addEventListener('click', function(e) {
            e.preventDefault(); 

            form.reset();

            form.classList.remove('was-validated'); 
            
            const inputs = form.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid'); 
            });

            if(feedbackFoto) feedbackFoto.textContent = "Rasio foto harus 3x4. Silakan unggah ulang."; 

            setInputValue("posisi", "posisi", "posisiDilamar");
            setInputValue("lowongan_id", "lowongan_id", "lowongan_id");
            setInputValue("departemen", "departemen", "departemenTujuan");
        });
    }
});