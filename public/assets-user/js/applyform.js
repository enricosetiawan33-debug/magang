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

    // 2. Validasi Foto (Rasio 3:4)
    const validateFotoRasio = (file) => {
        return new Promise((resolve) => {
            if (!file) { resolve(true); return; }
            const img = new Image();
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                img.onload = () => {
                    const rasio = img.width / img.height;
                    resolve(rasio >= 0.70 && rasio <= 0.80);
                };
            };
            reader.readAsDataURL(file);
        });
    };

    if (inputFoto) {
        inputFoto.addEventListener('change', async function() {
            const file = this.files[0];
            if (file) {
                const isValid = await validateFotoRasio(file);
                if (!isValid) {
                    this.setCustomValidity("Rasio foto salah.");
                    this.classList.add('is-invalid');
                    feedbackFoto.textContent = "Rasio foto harus 3x4 (Potrait).";
                } else {
                    this.setCustomValidity("");
                    this.classList.remove('is-invalid');
                }
            }
        });
    }

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

            if (inputFoto && inputFoto.files[0]) {
                const isFotoValid = await validateFotoRasio(inputFoto.files[0]);
                if (!isFotoValid) {
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

    // 5. Logic Tombol "Kirim Final" (BACKGROUND SUBMIT / FETCH)
    const agreeCheck = document.getElementById('agreeCheck');
    const btnFinalSubmit = document.getElementById('btnFinalSubmit');
    const consentModalEl = document.getElementById('consentModal');

    if(agreeCheck && btnFinalSubmit){
        // Toggle Tombol saat Checkbox diklik
        agreeCheck.addEventListener('change', function() {
            if (this.checked) {
                btnFinalSubmit.removeAttribute('disabled');
                btnFinalSubmit.classList.remove('disabled-btn');
            } else {
                btnFinalSubmit.setAttribute('disabled', 'true');
                btnFinalSubmit.classList.add('disabled-btn');
            }
        });

        // === ACTION UTAMA: KIRIM TANPA RELOAD LAYAR ===
        btnFinalSubmit.addEventListener('click', function() {
            // A. Tampilan Loading
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            this.disabled = true;

            // B. Ambil Data Form
            const formData = new FormData(form);

            // C. Kirim via Fetch (Browser diam, tidak pindah halaman)
            fetch(form.action, {
                method: 'POST',
                body: formData,
                redirect: 'follow' 
            })
            .then(response => {
                // Apapun balasannya (Redirect ke halaman sukses / Error), 
                // kita anggap server sudah menerima jika statusnya OK.
                if (response.ok) {
                    return response.text(); 
                }
                throw new Error('Gagal terhubung ke server.');
            })
            .then(html => {
                // D. Sukses! Sembunyikan Modal Consent
                const consentModal = bootstrap.Modal.getInstance(consentModalEl);
                consentModal.hide();

                // E. Munculkan Modal Sukses (Manual JS)
                const successModalEl = document.getElementById('successModal');
                if(successModalEl){
                    const successModal = new bootstrap.Modal(successModalEl, {
                        backdrop: 'static', keyboard: false
                    });
                    successModal.show();
                }

                // F. Reset Form
                form.reset();
                form.classList.remove('was-validated');
                btnFinalSubmit.setAttribute('disabled', 'true');
                btnFinalSubmit.classList.add('disabled-btn');
                agreeCheck.checked = false;
                this.innerHTML = originalText;
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Gagal mengirim lamaran. Pastikan koneksi stabil.");
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    }
});