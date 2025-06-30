<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<div class="container py-4">

  
 <!-- Komponen user info + saldo (sudah modular) -->
<?= view_cell(\App\Cells\PortoCell::class) ?>


  <!-- Layanan -->
  <?php foreach ($services as $service): ?>
  <div class="col-3 col-sm-3 col-md-2 mb-4">
    <a href="<?= site_url('pay?code=' . urlencode($service['service_code'])) ?>" class="text-decoration-none text-dark">
      <img src="<?= esc($service['service_icon']) ?>" width="40" class="mb-2">
      <p class="small text-truncate"><?= esc($service['service_name']) ?></p>
    </a>
  </div>
<?php endforeach; ?>


  <!-- Banner -->
  <h5 class="fw-bold mb-3">Temukan promo menarik</h5>
  <div class="row">
    <?php foreach ($banners as $banner): ?>
      <div class="col-md-4 mb-3">
        <img src="<?= esc($banner['banner_image']) ?>" class="img-fluid rounded shadow-sm w-100">
      </div>
    <?php endforeach; ?>
  </div>

</div>
<?= $this->endSection() ?>
