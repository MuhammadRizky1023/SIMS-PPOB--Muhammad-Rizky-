<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="row">
     <!-- Komponen Info Pengguna & Saldo -->
    <?= view_cell(\App\Cells\PortoCell::class) ?>
    <!-- 💸 Pembayaran -->
    <div class="col-md-8">
      <h5 class="fw-bold mb-3">Pembayaran <span class="text-danger"><?= esc($service['service_name']) ?></span></h5>

      <!-- Flash Message -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form method="get" action="/pay">
        <input type="hidden" name="service_code" value="<?= esc($service['service_code']) ?>">
        <input type="hidden" name="submit" value="1">

        <div class="form-group mb-3">
          <label class="form-label">Nominal Tagihan</label>
          <input type="text" class="form-control" value="Rp<?= number_format($service['service_tariff'], 0, ',', '.') ?>" readonly>
        </div>

        <button type="submit" class="btn btn-danger w-100">Bayar Sekarang</button>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
