document.addEventListener("DOMContentLoaded", () => {
  AOS.init({ duration: 1000, once: true });

  // === Dummy data pelamar ===
  const dummyApplicants = [
    {
      id: 1,
      name: "Rina Kusuma",
      division: "IT",
      position: "Web Developer",
      status: "Diproses",
      date: "2025-10-20",
      details: {
        nik: "3201122001010001",
        birth: "Jakarta, 20 Januari 2001",
        address: "Jl. Merpati No. 10, Jakarta",
        education: "S1 Informatika - Universitas Budi Luhur",
        cv: "uploads/CV_Rina.pdf",
        ktp: "uploads/KTP_Rina.jpg",
        surat: "uploads/SuratLamaran_Rina.pdf"
      }
    },
    {
      id: 2,
      name: "Budi Santoso",
      division: "Keuangan",
      position: "Accounting Intern",
      status: "Diterima",
      date: "2025-10-18",
      details: {
        nik: "3202110309980002",
        birth: "Bandung, 3 September 1998",
        address: "Jl. Sukajadi No. 45, Bandung",
        education: "D3 Akuntansi - Politeknik Negeri Bandung",
        cv: "uploads/CV_Budi.pdf",
        ktp: "uploads/KTP_Budi.jpg",
        surat: "uploads/SuratLamaran_Budi.pdf"
      }
    },
    {
      id: 3,
      name: "Laila Nur",
      division: "SDM",
      position: "HR Assistant",
      status: "Ditolak",
      date: "2025-10-19",
      details: {
        nik: "32100515090003",
        birth: "Bogor, 15 September 2000",
        address: "Jl. Pandan No. 22, Bogor",
        education: "S1 Psikologi - Universitas Pakuan",
        cv: "uploads/CV_Laila.pdf",
        ktp: "uploads/KTP_Laila.jpg",
        surat: "uploads/SuratLamaran_Laila.pdf"
      }
    }
  ];

  // Simpan ke localStorage kalau belum ada
  if (!localStorage.getItem("applicants")) {
    localStorage.setItem("applicants", JSON.stringify(dummyApplicants));
  }

  let applicants = JSON.parse(localStorage.getItem("applicants"));
  const tableBody = document.querySelector("#applicantTable tbody");

  const filterDivision = document.getElementById("filterDivision");
  const filterPosition = document.getElementById("filterPosition");
  const filterStatus = document.getElementById("filterStatus");
  const searchName = document.getElementById("searchName");

  // === Render table ===
  function renderTable() {
    tableBody.innerHTML = "";
    const divVal = filterDivision.value;
    const posVal = filterPosition.value;
    const statVal = filterStatus.value;
    const searchVal = searchName.value.toLowerCase();

    const filtered = applicants.filter(a =>
      (divVal === "" || a.division === divVal) &&
      (posVal === "" || a.position === posVal) &&
      (statVal === "" || a.status === statVal) &&
      (a.name.toLowerCase().includes(searchVal))
    );

    filtered.forEach((a, i) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${a.name}</td>
        <td>${a.division}</td>
        <td>${a.position}</td>
        <td><span class="badge-status ${a.status}">${a.status}</span></td>
        <td>${a.date}</td>
        <td>
          <button class="btn btn-sm btn-outline-secondary me-1 btn-detail" data-id="${a.id}">
            <i class="bi bi-eye"></i> Detail
          </button>
          <button class="status-btn status-process me-1" data-id="${a.id}" data-status="Diproses">Diproses</button>
          <button class="status-btn status-accept me-1" data-id="${a.id}" data-status="Diterima">Diterima</button>
          <button class="status-btn status-reject" data-id="${a.id}" data-status="Ditolak">Ditolak</button>
        </td>
      `;
      tableBody.appendChild(row);
    });
  }

  // === Filter options ===
  function populateFilters() {
    const divisions = [...new Set(applicants.map(a => a.division))];
    const positions = [...new Set(applicants.map(a => a.position))];

    divisions.forEach(div => {
      const opt = document.createElement("option");
      opt.value = div;
      opt.textContent = div;
      filterDivision.appendChild(opt);
    });

    positions.forEach(pos => {
      const opt = document.createElement("option");
      opt.value = pos;
      opt.textContent = pos;
      filterPosition.appendChild(opt);
    });
  }

  // === Detail modal ===
  function showDetail(id) {
    const applicant = applicants.find(a => a.id === id);
    const content = `
      <div class="row">
        <div class="col-md-6">
          <p><strong>Nama:</strong> ${applicant.name}</p>
          <p><strong>NIK:</strong> ${applicant.details.nik}</p>
          <p><strong>Tempat/Tgl Lahir:</strong> ${applicant.details.birth}</p>
          <p><strong>Alamat:</strong> ${applicant.details.address}</p>
          <p><strong>Pendidikan:</strong> ${applicant.details.education}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Divisi:</strong> ${applicant.division}</p>
          <p><strong>Posisi:</strong> ${applicant.position}</p>
          <p><strong>Status:</strong> ${applicant.status}</p>
          <hr>
          <p><strong>Dokumen:</strong></p>
          <ul>
            <li><a href="${applicant.details.cv}" target="_blank">CV</a></li>
            <li><a href="${applicant.details.ktp}" target="_blank">KTP</a></li>
            <li><a href="${applicant.details.surat}" target="_blank">Surat Lamaran</a></li>
          </ul>
        </div>
      </div>
    `;
    document.getElementById("detailContent").innerHTML = content;
    new bootstrap.Modal(document.getElementById("detailModal")).show();
  }

  // === Update status ===
  function updateStatus(id, newStatus) {
    applicants = applicants.map(a =>
      a.id === id ? { ...a, status: newStatus } : a
    );
    localStorage.setItem("applicants", JSON.stringify(applicants));
    renderTable();
  }

  // === Event Listeners ===
  filterDivision.addEventListener("change", renderTable);
  filterPosition.addEventListener("change", renderTable);
  filterStatus.addEventListener("change", renderTable);
  searchName.addEventListener("input", renderTable);

  tableBody.addEventListener("click", e => {
    if (e.target.closest(".btn-detail")) {
      const id = parseInt(e.target.closest(".btn-detail").dataset.id);
      showDetail(id);
    }
    if (e.target.closest(".status-btn")) {
      const id = parseInt(e.target.closest(".status-btn").dataset.id);
      const newStatus = e.target.closest(".status-btn").dataset.status;
      updateStatus(id, newStatus);
    }
  });

  // Sidebar toggle
  const sidebar = document.getElementById("sidebar");
  document.getElementById("toggleSidebar").addEventListener("click", () => sidebar.classList.toggle("collapsed"));
  document.getElementById("mobileToggle").addEventListener("click", () => sidebar.classList.toggle("collapsed"));

  populateFilters();
  renderTable();
});