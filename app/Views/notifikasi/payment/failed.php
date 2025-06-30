<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="modal show d-block" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="text-danger display-1 mb-3">✕</div>
      <h5>Pembayaran <?= esc($service_name) ?> sebesar</h5>
      <h4 class="fw-bold">Rp<?= number_format($amount, 0, ',', '.') ?></h4>
      <p class="text-muted">gagal</p>
      <a href="/" class="btn btn-link text-danger">Kembali ke Beranda</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
