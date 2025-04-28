<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login') ?> - HIS PPOB</title>
    <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="row g-0 min-vh-100">
    <!-- Form Kiri -->
    <div class="col-lg-6 d-flex flex-column justify-content-center p-5">
        <div class="mb-4">
            <img src="/Website Assets/Logo.png" alt="Logo" style="width: 150px;">
        </div>
        <h3 class="mb-4">Masuk atau buat akun untuk memulai</h3>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="/login">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Masukkan password anda" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-danger">Masuk</button>
            </div>
        </form>

        <p class="text-center mt-3">
            Belum punya akun? <a href="/register" class="text-danger">Registrasi di sini</a>
        </p>
    </div>

    <!-- Gambar Kanan -->
    <div class="col-lg-6 d-none d-lg-block bg-light">
        <img src="/Website Assets/Illustrasi Login.png" alt="Ilustrasi Login" class="img-fluid vh-100" style="object-fit: cover;">
    </div>
</div>
<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

