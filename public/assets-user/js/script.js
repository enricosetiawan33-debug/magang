// Script untuk interaksi sederhana
document.addEventListener("DOMContentLoaded", () => {
console.log("Halaman siap!");

  // Waktu user klik menu Program Magang
const magangMenu = document.querySelector("a.nav-link[href='#']");
if (magangMenu) {
    magangMenu.addEventListener("click", (e) => {
    e.preventDefault();
    alert("Menu Program Magang sedang dalam pengembangan.");
    });
}
});