<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMS PPOB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .form-section{
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .image-section{
            flex: 1;
            background-color: #ffecec;
            display: none;
            align-items: center;
            justify-content: center;
        }
        @media (min-width: 768px) {
        .image-section {
            display: flex;
      }
    }
    </style>
</head>
<body>
    <div class="form-section">
    <div class="w-100" style="max-width: 400px;">
      <img src="<?= base_url('assets/Logo.png') ?>" class="mb-4" alt="SIMS PPOB" style="width: 150px;">
      <h2 class="mb-4 fw-bold">Selamat datang kembali</h2>
      <p class="text-muted mb-4">Silakan login untuk melanjutkan</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form method="post" action="/login">
        <!-- Email -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control" name="email" placeholder="email" required>
        </div>

        <!-- Password -->
        <div class="input-group mb-4">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="password" placeholder="password" required>
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-danger w-100">Login</button>

        <p class="mt-3 text-center">belum punya akun? <a href="/register" class="text-danger fw-bold">daftar di sini</a></p>
      </form>
    </div>
  </div>

  <!-- Right: Illustration -->
  <div class="image-section">
  <img src="<?= base_url('assets/Illustrasi Login.png') ?>" alt="Ilustrasi" class="img-fluid" style="max-width: 400px;">
  </div>
</body>
</html>