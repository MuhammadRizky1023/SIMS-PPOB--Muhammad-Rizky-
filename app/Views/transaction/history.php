<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

  <!-- Komponen Info Pengguna & Saldo -->
  <?= view_cell(\App\Cells\PortoCell::class) ?>

  <!-- Filter Bulan -->
  <div class="my-3">
    <div class="d-flex flex-wrap gap-2">
      <?php foreach ($availableMonths as $eng => $indo): ?>
        <a href="?month=<?= $eng ?>" class="btn btn-sm <?= $selectedMonth === $eng ? 'btn-dark' : 'btn-outline-secondary' ?>">
          <?= $indo ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Histori Transaksi -->
  <div class="mt-4">
    <h5 class="mb-3">Histori Transaksi</h5>

    <?php if (empty($transactions)): ?>
      <div class="alert alert-warning text-center">
        Maaf, tidak ada histori transaksi di bulan ini.
      </div>
    <?php else: ?>
      <?php foreach ($transactions as $trx): ?>
        <div class="card mb-3 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-1 text-<?= $trx['type'] === 'topup' ? 'success' : 'danger' ?>">
                <?= $trx['type'] === 'topup' ? '+' : '-' ?>
                Rp<?= number_format($trx['amount'], 0, ',', '.') ?>
              </h6>
              <small class="text-muted">
                <?= date('d F Y', strtotime($trx['created_at'])) ?> - <?= date('H:i', strtotime($trx['created_at'])) ?> WIB
              </small><br>
              <small class="text-secondary">
                <?= esc($trx['description'] ?? ($trx['type'] === 'topup' ? 'Top Up Saldo' : 'Pembayaran')) ?>
              </small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if ($hasMore): ?>
        <div class="text-center mt-3">
          <a href="?month=<?= $selectedMonth ?>&page=<?= $nextPage ?>" class="btn btn-outline-dark btn-sm">
            Tampilkan Lebih Banyak
          </a>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
