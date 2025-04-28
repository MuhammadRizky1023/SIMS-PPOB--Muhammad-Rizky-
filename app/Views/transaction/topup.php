<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
  <!-- Profile Section -->
   <?= view('components/profile', ['profile' => $profile]) ?>

<!-- Saldo Card -->
<?= view('components/balance', ['balance' => $balance]) ?>


  <!-- Flash Messages -->
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Top Up Form -->
  <div class="mb-4 text-center">
    <h4>Silahkan masukkan</h4>
    <h2 class="fw-bold">Nominal Top Up</h2>
  </div>

  <form id="topupForm" action="/transaction/topup" method="POST" class="text-center">
    <?= csrf_field() ?>
    <div class="mb-3">
      <input type="number" name="top_up_amount" id="top_up_amount" class="form-control form-control-lg text-center" placeholder="Masukkan nominal Top Up" required min="10000" max="1000000">
    </div>

    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(10000)">Rp10.000</button>
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(20000)">Rp20.000</button>
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(50000)">Rp50.000</button>
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(100000)">Rp100.000</button>
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(250000)">Rp250.000</button>
      <button type="button" class="btn btn-outline-secondary" onclick="setAmount(500000)">Rp500.000</button>
    </div>

    <div class="d-grid">
      <button id="topUpButton" type="submit" class="btn btn-danger btn-lg" disabled>Top Up</button>
    </div>
  </form>

</div>

<!-- Include notification views -->
<?= $this->include('notification/topup_notification'); ?>

<?php if (session()->getFlashdata('topup_success')) : ?>
    <?= $this->include('notification/topup_success'); ?>
<?php elseif (session()->getFlashdata('topup_failed')) : ?>
    <?= $this->include('notification/topup_failed'); ?>
<?php endif; ?>

<!-- JavaScript untuk validasi dan pilih nominal -->
<script>
// Set amount dari tombol cepat
function setAmount(amount) {
    document.getElementById('top_up_amount').value = amount;
    validateAmount();
}

// Cek validasi nominal input
document.getElementById('top_up_amount').addEventListener('input', validateAmount);

function validateAmount() {
    const amount = parseInt(document.getElementById('top_up_amount').value);
    const button = document.getElementById('topUpButton');

    if (amount >= 10000 && amount <= 1000000) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}
</script>

<?= $this->endSection() ?>
