<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Profile Section -->
<?= view('components/profile', ['profile' => $profile]) ?>

<!-- Saldo Card -->
<?= view('components/balance', ['balance' => $balance]) ?>

<!-- Services Section -->
<?= view('components/services', ['services' => $services]) ?>

<!-- Promo Section -->
<?= view('components/promo', ['banners' => $banners]) ?>

<?= $this->endSection() ?>


