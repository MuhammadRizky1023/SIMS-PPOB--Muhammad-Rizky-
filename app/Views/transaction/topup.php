<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="row">
    
     <!-- Komponen Info Pengguna & Saldo -->
    <?= view_cell(\App\Cells\PortoCell::class) ?>

    <!-- 💰 Top Up -->
    <div class="col-md-8">
      <h5 class="fw-bold mb-3">Silakan masukkan <span class="text-danger">Nominal Top Up</span></h5>

      <!-- Flash Message -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form method="post" action="/topup">
        <div class="form-group mb-3">
          <input type="number" name="top_up_amount" id="top_up_amount" class="form-control" placeholder="Contoh: 100000" required>
        </div>

        <!-- Pilihan Cepat -->
        <div class="d-flex flex-wrap gap-2 mb-3">
          <?php foreach ([10000, 20000, 50000, 100000, 250000, 500000] as $amount): ?>
            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('top_up_amount').value = <?= $amount ?>;">
              Rp<?= number_format($amount, 0, ',', '.') ?>
            </button>
          <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-danger w-100">Top Up</button>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
