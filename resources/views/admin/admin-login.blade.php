<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - Biro Umum dan Pengadaan Barang dan Jasa</title>
    <link rel="stylesheet" href="assets-admin/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets-admin/css/admin-login.css">
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 400px;">
            <h4 class="text-center mb-3 text-primary fw-semibold">Login Admin</h4>
            <p class="text-center text-muted mb-4">Masuk untuk mengelola data kandidat dan lowongan</p>
            
            <form id="loginForm" action="" method="POST" novalidate>
            @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Admin</label>
                    <input type="email" id="email" class="form-control" placeholder="admin@instansi.go.id" required>
                    <div class="invalid-feedback">Email wajib diisi</div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                    <div class="invalid-feedback">Kata sandi wajib diisi</div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    
    <script src="assets-admin/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets-admin/js/admin-login.js"></script>
</body>
</html>