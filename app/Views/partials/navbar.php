<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="<?= site_url('/') ?>">
      <img src="assets/Logo.png" alt="Logo" width="24" class="me-1"> SIMS PPOB
    </a>

    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= uri_string() === 'topup' ? 'text-danger fw-bold' : '' ?>" href="<?= site_url('/topup') ?>">Top Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= uri_string() === 'pay' ? 'text-danger fw-bold' : '' ?>" href="<?= site_url('/pay') ?>">Transaction</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= uri_string() === 'profile' ? 'text-danger fw-bold' : '' ?>" href="<?= site_url('/profile') ?>">Akun</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
