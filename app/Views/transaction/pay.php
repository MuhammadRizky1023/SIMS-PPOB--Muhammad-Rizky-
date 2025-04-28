<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5" style="max-width: 800px;">

<div class="container py-5">
  <!-- Profile Section -->
   <?= view('components/profile', ['profile' => $profile]) ?>
  <!-- Saldo Card -->
  <?= view('components/balance', ['balance' => $balance]) ?>

    <!-- Service Info -->
    <div class="text-center mb-4">
        <h5>Pembayaran</h5>
        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
            <img src="<?= esc($service['service_icon']) ?>" alt="Service Icon" style="width: 30px; height: 30px;">
            <h4 class="fw-bold mb-0"><?= esc($service['service_name']) ?></h4>
        </div>
    </div>

    <!-- Payment Form -->
    <form action="<?= site_url('/transaction/pay') ?>" method="POST" class="text-center">
        <?= csrf_field() ?>
        <input type="hidden" name="service_code" value="<?= esc($service['service_code']) ?>">

        <div class="mb-4">
            <input type="text" class="form-control form-control-lg text-center" value="Rp <?= number_format($service['service_tariff'], 0, ',', '.') ?>" readonly>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-danger btn-lg">Bayar</button>
        </div>
    </form>

</div>
<!-- Include notification views -->
<?= $this->include('notification/pay_notification'); ?>

<?php if (session()->getFlashdata('pay_success')) : ?>
    <?= $this->include('notification/pay_success'); ?>
<?php elseif (session()->getFlashdata('pay_failed')) : ?>
    <?= $this->include('notification/pay_failed'); ?>
<?php endif; ?>
<?= $this->endSection() ?>
