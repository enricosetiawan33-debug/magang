// === joblist.js (FINAL FIX: Level & Date) ===

const dbJobs = window.lowonganData || [];

// === 1. FORMATTING DATA SEBELUM RENDER ===
const jobs = dbJobs.map(job => { 
  
  // A. Format Requirements (Jurusan)
  let jobRequirements = [];
  if (job.requirements) {
      jobRequirements = job.requirements
          .replace(/[.\s]+/g, ' ') 
          .split('"') 
          .map(r => r.trim()) 
          .filter(r => r.length > 0 && r !== '.'); 
  }

  // B. Format Tanggal (ISO -> Indonesia: 31 Januari 2026)
  let formattedDate = '-';
  if (job.deadline) {
      const dateObj = new Date(job.deadline);
      formattedDate = dateObj.toLocaleDateString('id-ID', { 
          day: 'numeric', 
          month: 'long', 
          year: 'numeric' 
      });
  }

  // C. Format Level (Agar tidak null)
  let displayLevel = "-"; 
  let raw = job.level;

  if (raw && raw !== 'null') {
      if (Array.isArray(raw)) {
          // Jika data sudah array (dari cast Laravel)
          displayLevel = raw.join(', ');
      } else if (typeof raw === 'string') {
          // Jika string, cek apakah itu JSON (kurung siku) atau text biasa
          if (raw.trim().startsWith('[')) {
              try {
                  const parsed = JSON.parse(raw);
                  displayLevel = Array.isArray(parsed) ? parsed.join(', ') : parsed;
              } catch (e) {
                  displayLevel = raw; // Gagal parse, pakai string aslinya
              }
          } else {
              displayLevel = raw; // Text biasa (misal: "D3/S1")
          }
      }
  }

  return { 
    id: job.id,
    title: job.title,
    dept: job.division ?? 'Umum',
    level: displayLevel, // Gunakan hasil olahan di atas
    quota: job.quota,
    deadline: job.deadline, // Data asli untuk sorting
    formatted_deadline: formattedDate, // Data cantik untuk tampilan
    description: job.description, 
    requirements: jobRequirements 
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const jobsContainer = document.getElementById("jobsContainer");
  const resultCount = document.getElementById("resultCount");
  const gridViewBtn = document.getElementById("gridViewBtn");
  const listViewBtn = document.getElementById("listViewBtn");

  // Filter Elements
  const qSearch = document.getElementById("qSearch");
  const filterDept = document.getElementById("filterDept");
  const filterLevel = document.getElementById("filterLevel");
  const sortBy = document.getElementById("sortBy");
  const btnReset = document.getElementById("btnReset");

  let currentFilters = { search: '', dept: '', level: '', sort: 'recent' };

  // --- Populate Filter ---
  const populateDepartmentFilter = () => {
      const allDepartments = jobs.map(job => job.dept);
      const uniqueDepartments = [...new Set(allDepartments)].sort();
      while (filterDept.options.length > 1) filterDept.remove(1);
      uniqueDepartments.forEach(dept => {
          if (dept) {
              const option = document.createElement('option');
              option.value = dept;
              option.textContent = dept;
              filterDept.appendChild(option);
          }
      });
  };

  // --- Filter & Sort Logic ---
  const applyFiltersAndSort = (data) => {
    let filteredJobs = [...data];
    const now = new Date();
    
    // Filter Deadline (Hanya tampilkan yang belum lewat)
    filteredJobs = filteredJobs.filter(job => {
        if (!job.deadline) return true;
        const deadlineDate = new Date(job.deadline);
        deadlineDate.setHours(23, 59, 59, 999);
        return now <= deadlineDate;
    });

    if (currentFilters.search) {
      const query = currentFilters.search.toLowerCase();
      filteredJobs = filteredJobs.filter(job => 
        job.title.toLowerCase().includes(query)
      );
    }

    if (currentFilters.dept) {
      filteredJobs = filteredJobs.filter(job => job.dept === currentFilters.dept);
    }

    if (currentFilters.level) {
        const filterValue = currentFilters.level.toUpperCase();
        filteredJobs = filteredJobs.filter(job => {
            const jobLevelString = String(job.level).toUpperCase();
            if (filterValue.includes('SMA') || filterValue.includes('SMK')) {
                return jobLevelString.includes('SMA') || 
                       jobLevelString.includes('SMK') || 
                       jobLevelString.includes('SLTA') || 
                       jobLevelString.includes('SEDERAJAT');
            }
            return jobLevelString.includes(filterValue);
        });
    }

    filteredJobs.sort((a, b) => {
      if (currentFilters.sort === 'recent') {
        return b.id - a.id; 
      } else if (currentFilters.sort === 'deadline') {
        return new Date(a.deadline) - new Date(b.deadline);
      } else if (currentFilters.sort === 'title') {
        return a.title.localeCompare(b.title);
      }
      return 0;
    });

    return filteredJobs;
  };

  // --- Layout Toggle ---
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
        renderJobs();
      });
  }

  // --- Render Function ---
  const renderJobs = () => {
    const displayedJobs = applyFiltersAndSort(jobs);
    jobsContainer.innerHTML = "";

    if (displayedJobs.length === 0) {
        jobsContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> Tidak ada lowongan yang ditemukan sesuai filter.
                </div>
            </div>`;
        resultCount.textContent = 0;
        return;
    }
    
    const isListView = jobsContainer.classList.contains("list-view");

    displayedJobs.forEach((job) => {
      const card = document.createElement("div");
      card.className = isListView ? "col-12" : "col-md-6 col-lg-4"; 
      
      // Menggunakan variable yang sudah diformat: job.level & job.formatted_deadline
      card.innerHTML = `
      <div class="card shadow-sm border-0 h-100 hover-card job-card d-flex flex-column">
        <div class="card-body flex-grow-1"> 
            <h6 class="fw-semibold text-primary job-title">${job.title}</h6> 
            <div class="job-meta-group pt-2">
                <p class="small text-muted mb-1"><i class="bi bi-building"></i> ${job.dept}</p>
                <p class="small text-muted mb-1"><i class="bi bi-mortarboard"></i> ${job.level}</p> 
                <p class="small text-muted mb-1"><i class="bi bi-calendar-date"></i> ${job.formatted_deadline}</p>
                <p class="small text-muted mb-0"><i class="bi bi-people"></i> Kuota: ${job.quota} orang</p>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0 pb-3"> 
            <button class="btn btn-primary btn-sm w-100 detail-btn" data-id="${job.id}">
                <i class="bi bi-info-circle me-1"></i> Detail
            </button>
        </div>
      </div>`;
      jobsContainer.appendChild(card);
    });

    resultCount.textContent = displayedJobs.length;
  };

  // --- Event Listeners ---
  qSearch.addEventListener('input', () => { currentFilters.search = qSearch.value; renderJobs(); });
  filterDept.addEventListener('change', () => { currentFilters.dept = filterDept.value; renderJobs(); });
  filterLevel.addEventListener('change', () => { currentFilters.level = filterLevel.value; renderJobs(); });
  sortBy.addEventListener('change', () => { currentFilters.sort = sortBy.value; renderJobs(); });
  
  btnReset.addEventListener('click', () => {
      qSearch.value = ''; filterDept.value = ''; filterLevel.value = ''; sortBy.value = 'recent';
      currentFilters = { search: '', dept: '', level: '', sort: 'recent' };
      renderJobs();
  });

  populateDepartmentFilter();
  renderJobs();

  // ==== LOGIKA MODAL DETAIL ====
  const jobModalElement = document.getElementById("jobModal");
  const jobModal = new bootstrap.Modal(jobModalElement);
  
  const modalTitle = document.getElementById("jobModalTitle");
  const modalBody = document.getElementById("jobModalBody");
  const modalDept = document.getElementById("jobDept");
  const modalDeadline = document.getElementById("jobDeadline");

  const setupEduCard = (type, isActive, requirementsHTML, quotaValue) => {
      const card = document.getElementById(`card-${type}`);
      const content = document.getElementById(`content-${type}`);
      const lock = document.getElementById(`lock-${type}`);
      const btn = document.getElementById(`btn-${type}`);
      const list = document.getElementById(`list-${type}`);
      const statusText = document.getElementById(`status-${type}`);
      const quotaSpan = document.getElementById(`quota-${type}`);
      const quotaBox = document.getElementById(`quota-box-${type}`);

      if (isActive) {
          card.classList.remove("disabled");
          content.style.display = "block";
          lock.style.display = "none";
          quotaBox.style.display = "block"; 
          
          list.innerHTML = requirementsHTML;
          statusText.textContent = "(Status: Aktif)";
          quotaSpan.textContent = quotaValue + " Orang";

          btn.disabled = false;
          btn.classList.remove("btn-secondary");
          btn.classList.add("btn-primary");
          btn.innerHTML = type === 'sma' ? 'Daftar Jalur SMA/SMK' : (type === 'd3' ? 'Daftar Jalur D3' : 'Daftar Jalur D4/S1');
      } else {
          card.classList.add("disabled");
          content.style.display = "none";
          lock.style.display = "block"; 
          quotaBox.style.display = "none"; 
          
          list.innerHTML = "";
          statusText.textContent = "";
          quotaSpan.textContent = "";

          btn.disabled = true;
          btn.classList.remove("btn-primary");
          btn.classList.add("btn-secondary"); 
          btn.innerHTML = '<i class="bi bi-slash-circle me-1"></i> Tidak Tersedia';
      }
  };

  jobsContainer.addEventListener("click", (e) => {
    if (e.target.closest(".detail-btn")) {
      const id = e.target.closest(".detail-btn").dataset.id;
      const job = jobs.find((j) => j.id == id);

      if (!job) return; 

      modalTitle.textContent = job.title;
      modalBody.textContent = job.description;
      modalDept.textContent = job.dept;
      modalDeadline.textContent = job.formatted_deadline; // Gunakan tanggal format Indonesia
      
      const reqsHTML = job.requirements.length > 0 
          ? job.requirements.map((r) => `<li>${r}</li>`).join("")
          : "<li>Semua Jurusan Relevan</li>";

      let levelString = String(job.level).toUpperCase();

      const isSMA = levelString.includes("SMA") || levelString.includes("SMK") || levelString.includes("SLTA");
      const isD3  = levelString.includes("D3") || levelString.includes("DIPLOMA 3");
      const isS1  = levelString.includes("S1") || levelString.includes("D4") || levelString.includes("SARJANA");

      setupEduCard('sma', isSMA, reqsHTML, job.quota);
      setupEduCard('d3', isD3, reqsHTML, job.quota);
      setupEduCard('s1', isS1, reqsHTML, job.quota);

      localStorage.setItem("posisiDilamar", job.title);
      localStorage.setItem("departemenTujuan", job.dept);
      localStorage.setItem("lowongan_id", job.id);

      jobModal.show();
    }
  });

  jobModalElement.addEventListener("click", (e) => {
      if(e.target.classList.contains("btn-apply-track")) {
          const selectedLevel = e.target.getAttribute("data-level");
          localStorage.setItem("jenjang_terpilih", selectedLevel);

          document.body.style.transition = "opacity 0.5s ease";
          document.body.style.opacity = 0;
          setTimeout(() => {
              window.location.href = "/applyform";
          }, 500);
      }
  });
});