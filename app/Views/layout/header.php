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
        <a class="navbar-brand" href="/dashboard">SIMS PPOB</a>
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
