<div class="d-flex align-items-center gap-3 mb-3">
  <img src="<?= esc($user['profile_image']) ?>" class="rounded-circle" width="60" height="60" alt="User">
  <div>
    <p class="mb-1 text-muted">Selamat datang,</p>
    <h5 class="mb-0 fw-bold"><?= esc($user['name']) ?></h5>
    <small class="text-muted"><?= esc($user['email']) ?></small>
  </div>
</div>

<div class="card bg-danger text-white mb-4 rounded-4 shadow">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <p class="mb-1">Saldo Anda</p>
      <h3 class="mb-0 fw-bold">
        Rp <?= $hidden ? '••••••' : number_format($balance, 0, ',', '.') ?>
      </h3>
    </div>
    <form method="post" action="/toggle-saldo">
      <button class="btn btn-outline-light btn-sm rounded-pill" type="submit">
        <?= $hidden ? 'Lihat' : 'Sembunyikan' ?> 
        <i class="bi bi-eye<?= $hidden ? '' : '-slash' ?>"></i>
      </button>
    </form>
  </div>
</div>