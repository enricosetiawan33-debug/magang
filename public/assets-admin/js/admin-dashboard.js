document.addEventListener("DOMContentLoaded", () => {
  AOS.init({ duration: 800, once: true });

  // === DATA DIVISI & LOWONGAN ===
  const divisions = {
    "IT Intern": {
      "Web Developer": 12,
      "IT Support": 8,
      "Frontend Programmer": 10,
      "Backend Engineer": 5
    },
    "Data Engineer": {
      "Data Entry": 6,
      "Data Analyst": 9
    },
    "Finance": {
      "Accounting": 7
    },
    "Administrasi Umum": {
      "Resepsionis": 4
    }
  };

  const divisionApplicants = {};
  for (const [div, jobs] of Object.entries(divisions)) {
    divisionApplicants[div] = Object.values(jobs).reduce((a, b) => a + b, 0);
  }

  const total = Object.values(divisionApplicants).reduce((a, b) => a + b, 0);
  const accepted = Math.floor(total * 0.4);
  const pending = Math.floor(total * 0.35);
  const rejected = total - accepted - pending;

  document.getElementById("totalApplicants").textContent = total;
  document.getElementById("acceptedApplicants").textContent = accepted;
  document.getElementById("pendingApplicants").textContent = pending;
  document.getElementById("rejectedApplicants").textContent = rejected;

  // === SIDEBAR TOGGLE ===
  const sidebar = document.getElementById("sidebar");
  document.getElementById("toggleSidebar").onclick = () => sidebar.classList.toggle("collapsed");
  document.getElementById("mobileToggle").onclick = () => sidebar.classList.toggle("show");

  // === FILTER CHECKLIST ===
  const filterContainer = document.getElementById("filterDept");
  Object.keys(divisions).forEach(div => {
    const item = document.createElement("div");
    item.className = "form-check";
    item.innerHTML = `
      <input class="form-check-input" type="checkbox" value="${div}" id="chk-${div}">
      <label class="form-check-label" for="chk-${div}">${div}</label>
    `;
    filterContainer.appendChild(item);
  });

  const getSelectedDivisions = () =>
    Array.from(document.querySelectorAll("#filterDept input:checked")).map(c => c.value);

  // === CHART ===
  const ctx = document.getElementById("divisionChart").getContext("2d");
  let chart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: Object.keys(divisionApplicants),
      datasets: [{
        label: "Jumlah Pelamar",
        data: Object.values(divisionApplicants),
        backgroundColor: ["#4e73df", "#f6c23e", "#1cc88a", "#e74a3b"],
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });

  // === RENDER DIVISI ===
  const container = document.getElementById("jobStats");
  function renderJobs(selected = []) {
    container.innerHTML = "";
    Object.entries(divisions)
      .filter(([div]) => selected.length === 0 || selected.includes(div))
      .forEach(([div, jobs]) => {
        const totalDiv = Object.values(jobs).reduce((a, b) => a + b, 0);
        const jobList = Object.entries(jobs)
          .map(
            ([job, count]) => `
            <li><i class="bi bi-dot text-primary"></i> ${job} — 
            <span class="badge bg-light text-dark border">${count} pelamar</span></li>`
          )
          .join("");

        // Tentukan class warna sesuai divisi
        let divClass = "division-it";
        if (div === "Data Engineer") divClass = "division-data";
        else if (div === "Finance") divClass = "division-finance";
        else if (div === "Administrasi Umum") divClass = "division-admin";

        const divCard = `
          <div class="col-12" data-aos="fade-up">
            <div class="card border-0 shadow-sm mb-3 division-card ${divClass}">
              <div class="card-body">
                <div class="division-header mb-2">
                  <h6 class="fw-semibold text-primary mb-0">
                    <i class="bi bi-diagram-3 me-2"></i>${div}
                  </h6>
                  <span class="division-badge">${totalDiv} Pelamar</span>
                </div>
                <ul class="mb-0 ps-3">${jobList}</ul>
              </div>
            </div>
          </div>`;
        container.innerHTML += divCard;
      });
  }

  renderJobs();

  // === UPDATE CHART + LIST ===
  document.querySelectorAll("#filterDept input").forEach(chk => {
    chk.addEventListener("change", () => {
      const selected = getSelectedDivisions();
      const filteredLabels = selected.length ? selected : Object.keys(divisionApplicants);
      const filteredData = filteredLabels.map(d => divisionApplicants[d]);

      chart.data.labels = filteredLabels;
      chart.data.datasets[0].data = filteredData;
      chart.update();
      renderJobs(selected);
    });
  });

  document.getElementById("btnReset").onclick = () => {
    document.querySelectorAll("#filterDept input").forEach(chk => (chk.checked = false));
    chart.data.labels = Object.keys(divisionApplicants);
    chart.data.datasets[0].data = Object.values(divisionApplicants);
    chart.update();
    renderJobs();
  };

  document.getElementById("refreshBtn").onclick = () => AOS.refreshHard();
});

 // === Sinkronisasi data dashboard antar tab ===

document.addEventListener("DOMContentLoaded", () => {
  AOS.init({ duration: 1000, once: true });

  // === Ambil data dari localStorage ===
  let applicants = JSON.parse(localStorage.getItem("applicants")) || [];

  // === Hitung total berdasarkan status ===
  const total = applicants.length;
  const diterima = applicants.filter(a => a.status === "Diterima").length;
  const diproses = applicants.filter(a => a.status === "Diproses").length;
  const ditolak = applicants.filter(a => a.status === "Ditolak").length;

  // === Tampilkan di dashboard ===
  document.getElementById("countTotal").textContent = total;
  document.getElementById("countAccepted").textContent = diterima;
  document.getElementById("countInProcess").textContent = diproses;
  document.getElementById("countRejected").textContent = ditolak;

  // === Hitung jumlah pelamar per divisi ===
  const divisiCount = {};
  applicants.forEach(a => {
    divisiCount[a.division] = (divisiCount[a.division] || 0) + 1;
  });

  // === Siapkan data untuk grafik ===
  const labels = Object.keys(divisiCount);
  const values = Object.values(divisiCount);

  const ctx = document.getElementById("divisionChart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [{
        label: "Jumlah Pelamar per Divisi",
        data: values,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: { y: { beginAtZero: true } }
    }
  });
});