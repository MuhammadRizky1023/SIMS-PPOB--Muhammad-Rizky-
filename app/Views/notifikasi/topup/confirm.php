<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="modal show d-block" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <img src="<?= base_url('assets/Logo.png') ?>" width="40" class="mb-3" />
      <h5>Anda yakin ingin membayar</h5>
      <h4 class="fw-bold"><?= esc($service_name) ?></h4>
      <p class="mt-2">Sebesar:</p>
      <h4 class="fw-bold text-danger">Rp<?= number_format($amount, 0, ',', '.') ?></h4>
      <div class="mt-4">
        <a href="/pay?submit=1&service_code=<?= esc($service_code) ?>&amount=<?= $amount ?>" class="btn btn-danger me-2">
          Ya, Bayar Sekarang
        </a>
        <a href="/" class="btn btn-light">Batalkan</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
