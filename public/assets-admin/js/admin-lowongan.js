document.addEventListener("DOMContentLoaded", () => {
    AOS.init({ duration: 1000, once: true });
    
    const tableBody = document.querySelector("#jobTable tbody");
    const btnAdd = document.getElementById("btnAdd");
    const modalTitle = document.getElementById("modalTitle");
    const jobForm = document.getElementById("jobForm");
    const saveBtn = document.getElementById("saveJobBtn");
    const jobModal = new bootstrap.Modal(document.getElementById("jobModal"));
    let editingId = null;

  // Data default 
const defaultJobs = [
    { id: 1, title: "Web Developer", division: "IT Intern", level: "D3/S1", quota: 2, deadline: "2025-11-30", description: "Bertanggung jawab dalam pengembangan dan pemeliharaan website instansi.", active: true },
    { id: 2, title: "Frontend Porgrammer", division: "IT Intern", level: "D3/S1", quota: 1, deadline: "2025-12-05", description: "Membantu tim IT dalam merancang tampilan antarmuka pengguna (UI) yang interaktif dan responsif untuk aplikasi internal instansi.", active: true },
    { id: 3, title: "Backend Engineer", division: "IT Intern", level: "D3/S1", quota: 1, deadline: "2025-12-10", description: "Bertugas merancang dan mengembangkan sisi server dari aplikasi internal, termasuk integrasi database dan API.", active: true },
    { id: 4, title: "IT Support", division: "IT Intern", level: "SMK/D3/S1", quota: 3, deadline: "2025-11-25", description: "Memberikan dukungan teknis kepada pengguna internal, membantu troubleshooting perangkat keras dan perangkat lunak, serta melakukan instalasi jaringan sederhana.", active: true },
    { id: 5, title: "Resepsionis", division: "Administrasi Umum", level: "SMK/Sederajat", quota: 2, deadline: "2025-11-20", description: "Menyambut tamu instansi, menerima telepon, mengatur jadwal tamu, serta membantu administrasi umum di bagian depan.", active: true },
    { id: 6, title: "Data Entry", division: "Data Engineer", level: "D3/S1", quota: 1, deadline: "2025-12-15", description: "Melakukan entry dan pembaruan data ke dalam sistem instansi dengan akurasi tinggi serta mendukung kegiatan pengolahan data dasar.", active: true },
    { id: 7, title: "Data Analyst", division: "Data Engineer", level: "S1", quota: 1, deadline: "2025-12-20", description: "Menganalisis data operasional instansi, membuat laporan visualisasi, dan membantu pengambilan keputusan berbasis data.", active: true },
    { id: 8, title: "Accounting", division: "Finance Intern", level: "S1 Ekonomi/Manajemen", quota: 1, deadline: "2025-12-25", description: "Membantu tim keuangan dalam pencatatan transaksi, penyusunan laporan keuangan, serta verifikasi dokumen administrasi.", active: true }
];

  // Simpan defaultJobs 
const JOBS_VERSION = Date.now();
const savedVersion = localStorage.getItem("jobsVersion");
if (!localStorage.getItem("jobs") || savedVersion != JOBS_VERSION) {
    localStorage.setItem("jobs", JSON.stringify(defaultJobs));
    localStorage.setItem("jobsVersion", JOBS_VERSION);
}

let jobs = JSON.parse(localStorage.getItem("jobs"));

  // Render tabel
function renderTable() {
    tableBody.innerHTML = "";
    jobs.forEach((j, i) => {
        const row = document.createElement("tr");
        row.innerHTML = `
        <td>${i + 1}</td>
        <td>${j.title}</td>
        <td>${j.division}</td>
        <td>${j.level}</td>
        <td>${j.quota}</td>
        <td>${j.deadline}</td>
        <td><span class="status-badge ${j.active ? "status-active" : "status-inactive"}">${j.active ? "Aktif" : "Nonaktif"}</span></td>
        <td>
        
        <button class="btn btn-sm btn-outline-primary me-1 edit-btn" data-id="${j.id}"><i class="bi bi-pencil-square"></i></button>
        <button class="btn btn-sm btn-outline-danger me-1 delete-btn" data-id="${j.id}"><i class="bi bi-trash"></i></button>
        <button class="btn btn-sm btn-outline-warning toggle-btn" data-id="${j.id}"><i class="bi ${j.active ? "bi-toggle-on" : "bi-toggle-off"}"></i></button>
        </td>
        
        `;
        tableBody.appendChild(row);
    });
}

  // Tambah Lowongan
btnAdd.addEventListener("click", () => {
    jobForm.reset();
    editingId = null;
    modalTitle.textContent = "Tambah Lowongan";
    jobModal.show();
});

  // Simpan Lowongan
saveBtn.addEventListener("click", () => {
    const newJob = {
        id: editingId || Date.now(),
        title: document.getElementById("jobTitle").value,
        division: document.getElementById("jobDivision").value,
        quota: parseInt(document.getElementById("jobQuota").value),
        level: document.getElementById("jobLevel").value,
        deadline: document.getElementById("jobDeadline").value,
        description: document.getElementById("jobDesc").value,
        active: true
    };

    if (editingId) {
        jobs = jobs.map(j => (j.id === editingId ? newJob : j));
    } else {
        jobs.push(newJob);
    }

    localStorage.setItem("jobs", JSON.stringify(jobs));
    renderTable();
    jobModal.hide();
});

  // Aksi tombol
tableBody.addEventListener("click", e => {
    const id = parseInt(e.target.closest("button").dataset.id);
    const job = jobs.find(j => j.id === id);

    if (e.target.closest(".edit-btn")) {
        editingId = id;
        modalTitle.textContent = "Edit Lowongan";
        document.getElementById("jobTitle").value = job.title;
        document.getElementById("jobDivision").value = job.division;
        document.getElementById("jobQuota").value = job.quota;
        document.getElementById("jobLevel").value = job.level;
        document.getElementById("jobDeadline").value = job.deadline;
        document.getElementById("jobDesc").value = job.description;
        jobModal.show();
    }

    if (e.target.closest(".delete-btn")) {
        if (confirm("Yakin ingin menghapus lowongan ini?")) {
        jobs = jobs.filter(j => j.id !== id);
        localStorage.setItem("jobs", JSON.stringify(jobs));
        renderTable();
    }
}

    if (e.target.closest(".toggle-btn")) {
        job.active = !job.active;
        localStorage.setItem("jobs", JSON.stringify(jobs));
        renderTable();
    }
});

  // Sidebar toggle
const sidebar = document.getElementById("sidebar");
document.getElementById("toggleSidebar").addEventListener("click", () => sidebar.classList.toggle("collapsed"));
document.getElementById("mobileToggle").addEventListener("click", () => sidebar.classList.toggle("collapsed"));

renderTable();
});