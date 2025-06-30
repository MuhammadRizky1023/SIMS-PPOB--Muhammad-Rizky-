<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'SIMS PPOB' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Style tambahan opsional */
  </style>
</head>
<body>

  <!-- ✅ Include Navbar -->
  <?= view('partials/navbar') ?>

  <!-- ✅ Konten Halaman -->
  <main>
    <?= $this->renderSection('content') ?>
  </main>

  <!-- ✅ JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
