// === Inisialisasi AOS dan tombol Lanjutkan ===
document.addEventListener("DOMContentLoaded", () => {
  // Inisialisasi animasi AOS
  AOS.init({ duration: 1000, once: true });

  // Tombol "Lanjutkan" di modal
  const btnLanjutkan = document.getElementById("btnLanjutkan");

  if (btnLanjutkan) {
    btnLanjutkan.addEventListener("click", () => {
      const modalEl = document.getElementById("modalFollow");

      // Ambil atau buat instance modal Bootstrap
      let modal = bootstrap.Modal.getInstance(modalEl);
      if (!modal) {
        modal = new bootstrap.Modal(modalEl);
      }

      // Tutup modal
      modal.hide();

      // Tambahkan efek fade-out sebelum berpindah halaman
      setTimeout(() => {
        document.body.classList.add("fade-out");

        // Setelah efek selesai, arahkan ke joblist.html
        setTimeout(() => {
          window.location.href = "/joblist";
        }, 600); // 0.6s sesuai durasi transisi di style.css
      }, 300);
    });
  }
});