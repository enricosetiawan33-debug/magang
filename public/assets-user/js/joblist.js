// === joblist.js ===

// Ambil data lowongan dari variabel global yang di-set di joblist.blade.php
// Jika data tidak ada, gunakan array kosong sebagai fallback
const dbJobs = window.lowonganData || [];

// Kita akan memformat data dari database agar sesuai dengan kebutuhan tampilan dan filter
// Properti database: id, title, division, level, quota, deadline, description
// Properti JS sebelumnya: id, title, dept, level, location, quota, deadline, description, requirements

// Karena database tidak menyimpan 'requirements' dan 'location', kita hapus yang 'location'
// dan gunakan 'description' saja untuk detail (Anda mungkin perlu menambah kolom 'requirements' di DB)

// Memformat data dari database (lowongans) menjadi array 'jobs' yang siap digunakan JS
const jobs = dbJobs.map(job => { 
  

  let jobRequirements = [];
    
  if (job.requirements) {
      // 1. Hapus tanda titik (atau pemisah antar-poin Anda)
      // 2. Pisahkan string berdasarkan tanda kutip ganda
      // 3. Trim (hapus spasi) dan filter elemen yang kosong/tidak valid
      
      jobRequirements = job.requirements
          // Hapus semua karakter titik, spasi, atau pemisah lain di antara kutipan
          .replace(/[.\s]+/g, ' ') // Ganti titik dan spasi berulang dengan satu spasi (opsional: jika ada pemisah antar kutipan)
          .split('"') // Pisahkan berdasarkan tanda kutip ganda
          .map(r => r.trim()) // Bersihkan setiap elemen
          .filter(r => r.length > 0 && r !== '.'); // Pastikan hanya poin valid yang tersisa

      // Solusi sederhana lain jika formatnya bersih:
      // jobRequirements = job.requirements.split('"').filter(r => r.length > 1 && r.trim() !== '.');
  }

  // Kita kembalikan objek yang sudah lengkap.
  return { 
    id: job.id,
    title: job.title,
    dept: job.division, // Menggunakan 'division' dari DB sebagai 'dept'
    level: job.level,
    quota: job.quota,
    deadline: job.deadline,
    description: job.description, // Sekarang 'description' hanya berisi deskripsi
    requirements: jobRequirements // Sekarang 'requirements' langsung dari kolom DB
  }
});

// Menampilkan daftar lowongan magang dan interaksi modal

document.addEventListener("DOMContentLoaded", () => {
  const jobsContainer = document.getElementById("jobsContainer");
  const resultCount = document.getElementById("resultCount");

  const gridViewBtn = document.getElementById("gridViewBtn");
  const listViewBtn = document.getElementById("listViewBtn");

  // --- Elemen Filter/Sort ---
  const qSearch = document.getElementById("qSearch");
  const filterDept = document.getElementById("filterDept");
  const filterLevel = document.getElementById("filterLevel");
  const sortBy = document.getElementById("sortBy");
  const btnReset = document.getElementById("btnReset");

  // --- STATE SAAT INI ---
  let currentFilters = {
    search: '',
    dept: '',
    level: '',
    sort: 'recent'
  };

  // === FUNGSI BARU: POPULATE FILTER DEPARTEMEN ===
  const populateDepartmentFilter = () => {
      // 1. Ambil semua nilai departemen (dept/division) dari data 'jobs'
      const allDepartments = jobs.map(job => job.dept);
      
      // 2. Filter untuk mendapatkan nilai unik saja
      // Gunakan Set untuk mendapatkan nilai unik
      const uniqueDepartments = [...new Set(allDepartments)].sort();

      // 3. Hapus semua opsi lama (kecuali 'Semua')
      // Kita asumsikan opsi 'Semua' adalah yang pertama (index 0)
      while (filterDept.options.length > 1) {
          filterDept.remove(1);
      }

      // 4. Tambahkan opsi baru
      uniqueDepartments.forEach(dept => {
          if (dept) { // Pastikan nilai dept tidak kosong
              const option = document.createElement('option');
              option.value = dept;
              option.textContent = dept;
              filterDept.appendChild(option);
          }
      });
  };

  // ==== LOGIKA FILTERING & SORTING ====

  const applyFiltersAndSort = (data) => {
    let filteredJobs = [...data]; // Copy data agar tidak mengubah array asli

    // --- TAMBAHAN BARU: LOGIKA DEADLINE 23:59:59 ---
    const now = new Date(); // Waktu sekarang
    
    filteredJobs = filteredJobs.filter(job => {
        // Pastikan ada deadline
        if (!job.deadline) return true;

        // Konversi string tanggal dari DB (misal "2025-10-20") ke Objek Date
        const deadlineDate = new Date(job.deadline);
        
        // PENTING: Set jam ke 23:59:59 (Akhir Hari)
        // Ini memaksa deadline berlaku sampai detik terakhir di hari tersebut
        deadlineDate.setHours(23, 59, 59, 999);

        // Bandingkan: Tampilkan job hanya jika Waktu Sekarang <= Deadline Akhir Hari
        return now <= deadlineDate;
    });

    // 1. FILTER PENCARIAN (Search)
    if (currentFilters.search) {
      const query = currentFilters.search.toLowerCase();
      filteredJobs = filteredJobs.filter(job => 
        job.title.toLowerCase().includes(query)
      );
    }

    // 2. FILTER DEPARTEMEN (Dept / Division)
    if (currentFilters.dept) {
      filteredJobs = filteredJobs.filter(job => 
        job.dept === currentFilters.dept
      );
    }

    // 3. FILTER LEVEL (Level Pendidikan)
    if (currentFilters.level) {
        const filterValue = currentFilters.level.toUpperCase();
        
        filteredJobs = filteredJobs.filter(job => {
            // Pastikan job.level ada
            if (!job.level) return false; 
            
            const jobLevel = job.level.toUpperCase();

            // Jika filter adalah SMA/SMK, coba cocokkan dengan berbagai variasi di DB
            if (filterValue.includes('SMA/SMK')) {
                // Mencocokkan dengan 'SMA/SMK', 'SMK', atau 'SEDERAJAT'
                return jobLevel.includes('SMA/SMK') || 
                      jobLevel.includes('SMK') || 
                      jobLevel.includes('SEDERAJAT');
            }
            
            // Untuk D3, S1, atau filter lain, gunakan perbandingan normal
            return jobLevel.includes(filterValue);
        });
    }

    // 4. SORTING
    filteredJobs.sort((a, b) => {
      if (currentFilters.sort === 'recent') {
        // Sortir berdasarkan ID atau tanggal dibuat (kita gunakan ID/created_at jika ada)
        return b.id - a.id; // Terbaru = ID lebih besar di depan
      } else if (currentFilters.sort === 'deadline') {
        // Sortir berdasarkan deadline terdekat
        return new Date(a.deadline) - new Date(b.deadline);
      } else if (currentFilters.sort === 'title') {
        // Sortir berdasarkan Judul A->Z
        return a.title.localeCompare(b.title);
      }
      return 0;
    });

    return filteredJobs;
  };

  // Jika elemen ada (untuk menghindari error jika JS dipanggil di halaman lain)
  if (gridViewBtn && listViewBtn && jobsContainer) {
      gridViewBtn.addEventListener("click", () => {
        jobsContainer.classList.remove("list-view");
        gridViewBtn.classList.add("active");
        listViewBtn.classList.remove("active");
        renderJobs();
      });

      listViewBtn.addEventListener("click", () => {
        jobsContainer.classList.add("list-view");
        listViewBtn.classList.add("active");
        gridViewBtn.classList.remove("active");
        renderJobs(); // re-render kartu dalam bentuk list
      });
  }

  // ==== Render daftar lowongan ====
  const renderJobs = () => {
    // Terapkan filter dan sort sebelum rendering
    const displayedJobs = applyFiltersAndSort(jobs);
    
    // ... (Logika filter dan sort akan ditambahkan di sini, sementara ini kita render semua)
    jobsContainer.innerHTML = "";

    if (displayedJobs.length === 0) {
        jobsContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> Tidak ada lowongan yang ditemukan sesuai filter.
                </div>
            </div>
        `;
        resultCount.textContent = 0;
        return;
    }
    
    // Tentukan layout (grid/list)
    const isListView = jobsContainer.classList.contains("list-view");

    displayedJobs.forEach((job) => {
      const card = document.createElement("div");
      card.className = isListView ? "col-12" : "col-md-6 col-lg-4"; 
      
      card.innerHTML = `
      <div class="card shadow-sm border-0 h-100 hover-card job-card d-flex flex-column">
        
      <div class="card-body flex-grow-1"> 
        
        <h6 class="fw-semibold text-primary job-title">${job.title}</h6> 
        
        <div class="job-meta-group pt-2">
            <p class="small text-muted mb-1"><i class="bi bi-building"></i> ${job.dept}</p>
            <p class="small text-muted mb-1"><i class="bi bi-mortarboard"></i> ${job.level}</p>
            <p class="small text-muted mb-1">
				<i class="bi bi-calendar-date"></i> 
				${job.deadline.split('T')[0].split('-').reverse().join('-')}
			</p>
            <p class="small text-muted mb-0"><i class="bi bi-people"></i> Kuota: ${job.quota} orang</p>
        </div>
        
      </div>
      
      <div class="card-footer bg-white border-0 pt-0 pb-3"> 
          <button class="btn btn-primary btn-sm w-100 detail-btn" data-id="${job.id}">
            <i class="bi bi-info-circle me-1"></i> Detail
          </button>
      </div>
    </div>
      `;
      jobsContainer.appendChild(card);
    });

    resultCount.textContent = displayedJobs.length;
    // Panggil fungsi untuk update pagination di sini jika Anda mengimplementasikannya
  };

  // Search Input
  qSearch.addEventListener('input', () => {
      currentFilters.search = qSearch.value;
      renderJobs();
  });

  // Filter Departemen
  filterDept.addEventListener('change', () => {
      currentFilters.dept = filterDept.value;
      renderJobs();
  });

  // Filter Level
  filterLevel.addEventListener('change', () => {
      currentFilters.level = filterLevel.value;
      renderJobs();
  });

  // Sort By
  sortBy.addEventListener('change', () => {
      currentFilters.sort = sortBy.value;
      renderJobs();
  });

  // Tombol Reset
  btnReset.addEventListener('click', () => {
      qSearch.value = '';
      filterDept.value = '';
      filterLevel.value = '';
      sortBy.value = 'recent';
      
      currentFilters = {
          search: '',
          dept: '',
          level: '',
          sort: 'recent'
      };
      renderJobs();
  });

  populateDepartmentFilter();

  renderJobs();

  // ==== Modal Detail ====
  // ... (Pastikan semua variabel modal didefinisikan di sini jika Anda memindahkannya)
  const jobModal = new bootstrap.Modal(document.getElementById("jobModal"));
  const modalTitle = document.getElementById("jobModalTitle");
  const modalBody = document.getElementById("jobModalBody");
  const modalDept = document.getElementById("jobDept");
  const modalLevel = document.getElementById("jobLevel");
  const modalDeadline = document.getElementById("jobDeadline");
  const modalQuota = document.getElementById("jobQuota");
  const modalReqs = document.getElementById("jobReqs");
  const applyBtn = document.getElementById("applyBtn");

  jobsContainer.addEventListener("click", (e) => {
    if (e.target.closest(".detail-btn")) {
      const id = e.target.closest(".detail-btn").dataset.id;
      const job = jobs.find((j) => j.id == id);

      if (!job) return; // Jika tidak ketemu

      modalTitle.textContent = job.title;
      modalBody.textContent = job.description;
      modalDept.textContent = job.dept;
      modalLevel.textContent = job.level;
      modalDeadline.textContent = job.deadline.split('T')[0].split('-').reverse().join('-');
      modalQuota.textContent = job.quota;
      
      // Karena 'requirements' di-parse sederhana di atas, tampilkan saja hasilnya
      modalReqs.innerHTML = job.requirements.map((r) => `<li>${r.trim()}</li>`).join("");

      // Simpan posisi untuk bisa otomatis terisi di applyform
	  localStorage.setItem("lowonganId", job.id);
      localStorage.setItem("posisiDilamar", job.title);
      localStorage.setItem("departemenTujuan", job.dept);
      jobModal.show();
    }
  });

  // ==== Tombol Lamar Sekarang ====
  applyBtn.addEventListener("click", () => {
    document.body.style.transition = "opacity 0.5s ease";
    document.body.style.opacity = 0;
    setTimeout(() => {
      window.location.href = "/applyform";
    }, 500);
  });
});
