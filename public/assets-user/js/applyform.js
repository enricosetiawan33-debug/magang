// applyform.js
// Handle form submission, validation, and data from query string

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const posisiParam = urlParams.get("posisi");
    const posisiStorage = localStorage.getItem("posisiDilamar");
    const posisiInput = document.getElementById("posisi");
    if (posisiParam) {
        posisiInput.value = decodeURIComponent(posisiParam);
    } else if (posisiStorage) {
        posisiInput.value = posisiStorage;
    }

    const departemenStorage = localStorage.getItem("departemenTujuan");
    const departemenInput = document.getElementById("departemen");

    // LOGIKA UNTUK DEPARTEMEN
    if (departemenStorage) {
        // 1. Set nilai input departemen dari localStorage
        departemenInput.value = departemenStorage; 
    }

    const form = document.getElementById("applyForm");

    const inputFoto = document.getElementById("foto");
        const feedbackFoto = document.getElementById("foto-feedback");
        
        // Toleransi: Sedikit penyimpangan rasio diperbolehkan (misalnya 0.74 hingga 0.76)
        const RASIO_3X4 = 0.75; // 3 dibagi 4
        const TOLERANSI = 0.01;

        const validateFotoRasio = (file) => {
            return new Promise((resolve) => {
                if (!file) {
                    resolve(true); // Jika tidak ada file, anggap valid (validasi required akan menangani ini)
                    return;
                }
    
                const img = new Image();
                const reader = new FileReader();
    
                reader.onload = (e) => {
                    img.onload = () => {
                        const width = img.width;
                        const height = img.height;
                        
                        // Rasio = Lebar / Tinggi
                        // Untuk foto 3x4, rasionya 3/4 = 0.75
                        const rasioAktual = width / height;
    
                        // Cek apakah rasio aktual berada dalam rentang toleransi
                        if (rasioAktual >= RASIO_3X4 - TOLERANSI && rasioAktual <= RASIO_3X4 + TOLERANSI) {
                            resolve(true); // Rasio valid
                        } else {
                            // Jika rasio salah (misalnya, 4x3 atau 1:1)
                            resolve(false); // Rasio tidak valid
                        }
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        };

        if (inputFoto) {
            inputFoto.addEventListener('change', async function() {
                const file = this.files[0];
                
                // Atur pesan feedback kembali ke default
                feedbackFoto.textContent = "Rasio foto harus 3x4. Silakan unggah ulang.";
    
                if (file) {
                    const isValid = await validateFotoRasio(file);
                    
                    if (!isValid) {
                        // Set custom validity untuk memicu validasi Bootstrap
                        this.setCustomValidity("Rasio foto salah.");
                        this.classList.add('is-invalid'); // Tambah kelas error secara manual
                    } else {
                        // Reset custom validity jika valid
                        this.setCustomValidity(""); 
                        this.classList.remove('is-invalid'); // HAPUS tanda komentar di sini
                    }
                } else {
                    this.setCustomValidity(""); // Clear jika file dihapus
                    this.classList.remove('is-invalid'); // Pastikan error hilang jika file dihapus
                }

                // --- BAGIAN INI DIHAPUS ---
                // PENTING: Memicu validasi form agar pesan invalid-feedback muncul segera
                // form.classList.add('was-validated'); 
                // --------------------------
            });
        }

    const inputMulai = document.getElementById("mulai");
        const inputSelesai = document.getElementById("selesai");
        const inputDurasi = document.getElementById("durasi");
        
        // Rata-rata hari dalam sebulan: 365.25 / 12 = ~30.44
        const AVERAGE_DAYS_IN_MONTH = 31.44;

        // === DEKLARASI BATAS MINIMAL DAN MAKSIMAL DURASI ===
        const MIN_DURASI = 3; 
        const MAX_DURASI = 12;

        const hitungDurasi = () => {
            const tglMulai = new Date(inputMulai.value);
            const tglSelesai = new Date(inputSelesai.value);
            
            // Pastikan kedua tanggal terisi dan tanggal selesai TIDAK sebelum tanggal mulai
            if (inputMulai.value && inputSelesai.value && tglSelesai >= tglMulai) {
                
                // 1. Hitung selisih waktu dalam milidetik
                const diffTime = Math.abs(tglSelesai - tglMulai);
                
                // Karena kita ingin perhitungan inklusif (dari hari pertama hingga hari terakhir), 
                // kita tambahkan satu hari (86400000 ms) ke selisih waktu.
                // Contoh: 1 Des ke 1 Jan (31 hari) akan terhitung 31 hari penuh.
                const totalDurationTime = diffTime + (1000 * 60 * 60 * 24); 
                
                // 2. Konversi milidetik ke hari
                const diffDays = Math.ceil(totalDurationTime / (1000 * 60 * 60 * 24));
                
                // 3. Konversi hari ke bulan dan bulatkan ke atas (ceil)
                // Ini memastikan 1-31 hari = 1 bulan, 32-60 hari = 2 bulan, dst.
                const durasiBulan = Math.ceil(diffDays / AVERAGE_DAYS_IN_MONTH);

                // Update kolom durasi
                inputDurasi.value = durasiBulan;

                // === 4. VALIDASI BATAS MINIMAL DAN MAKSIMAL (JavaScript) ===
                if (durasiBulan < MIN_DURASI) {
                    // Tampilkan pesan kesalahan atau tandai sebagai tidak valid
                    inputDurasi.setCustomValidity(`Durasi minimal magang adalah ${MIN_DURASI} bulan.`);
                    inputDurasi.classList.add("is-invalid");
                } else if (durasiBulan > MAX_DURASI) {
                    inputDurasi.setCustomValidity(`Durasi maksimal magang adalah ${MAX_DURASI} bulan.`);
                    inputDurasi.classList.add("is-invalid");
                } else {
                    // Hapus custom validity jika sudah valid
                    inputDurasi.setCustomValidity("");
                    inputDurasi.classList.remove("is-invalid");
                }

            } else {
                // Reset jika input belum lengkap atau tanggal tidak valid
                inputDurasi.value = "";
                inputDurasi.setCustomValidity(""); // Pastikan validasi direset
                inputDurasi.classList.remove("is-invalid");
            }
        };

        inputMulai.addEventListener("change", hitungDurasi);
        inputSelesai.addEventListener("change", hitungDurasi);

        

    form.addEventListener("submit", async (event) => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');

        // // Validasi data diri
        // const requiredFields = ["nama", "nim", "univ", "jurusan", "email", "telepon", "departemen", "mulai", "selesai", "durasi", "cv", "transkrip", "surat", "ktp", "foto", "ktm"];
        // let valid = true;

        requiredFields.forEach(id => {
        const field = document.getElementById(id);
        if (!field.value) {
            field.classList.add("is-invalid");
            valid = false;
        } else {
            field.classList.remove("is-invalid");
        }
        });

        if (!valid) {
        alert("Harap lengkapi semua kolom yang wajib diisi.");
        return;
        }

        const fotoFile = inputFoto.files[0];
        if (fotoFile) {
            const isFotoValid = await validateFotoRasio(fotoFile);
            if (!isFotoValid) {
                event.preventDefault();
                event.stopPropagation();
                // Set ulang validitas agar pesan error muncul
                inputFoto.setCustomValidity("Rasio foto salah.");
                form.classList.add('was-validated');
                return; 
            } else {
                inputFoto.setCustomValidity(""); // Pastikan valid jika berhasil
            }
        }

        // Reset form setelah submit
        form.reset();
    });
});

