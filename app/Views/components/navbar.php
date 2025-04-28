<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIS PPOB - <?= esc($title ?? ''); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="/dashboard">
            <img src="<?= base_url('/Website Assets/Logo.png') ?>" alt="Logo" width="30" height="30" class="me-2">
            SIMS PPOB
        </a>
        <div>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/topup">Top Up</a></li>
                <li class="nav-item"><a class="nav-link" href="/history">Transaction</a></li>
                <li class="nav-item"><a class="nav-link" href="/profile">Akun</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">