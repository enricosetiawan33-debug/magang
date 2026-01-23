// assets/js/admin-login.js
document.addEventListener("DOMContentLoaded", () => {
    const ADMIN = {
    email: "admin@instansi.go.id",
    password: "admin123",
    name: "Administrator"
};

const form = document.getElementById("loginForm");
const inputEmail = document.getElementById("email");
const inputPassword = document.getElementById("password");

if (!form || !inputEmail || !inputPassword) return;

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    e.stopPropagation();

    // bootstrap validation visual
    form.classList.add("was-validated");

    const email = inputEmail.value.trim();
    const password = inputPassword.value;

    // basic client-side validation
    if (!email || !password) {
      // browser akan menampilkan invalid-feedback karena was-validated
    return;
    }

    // check hardcoded admin credentials
    if (email === ADMIN.email && password === ADMIN.password) {
      // tandain session sebagai admin logged in (gunakan sessionStorage)
    sessionStorage.setItem("isAdminLoggedIn", "true");
    sessionStorage.setItem("adminName", ADMIN.name);
      // optional: simpan email juga
    sessionStorage.setItem("adminEmail", ADMIN.email);

      // beri notifikasi singkat lalu redirect
    alert("Login berhasil. Mengalihkan ke Dashboard Admin...");
    window.location.href = "/dashboard";
    } else {
    alert("Email atau kata sandi admin salah. Gunakan akun dummy: admin@instansi.go.id / admin123");
    }
});
});