
<!-- Saldo Card -->
<div class="card bg-danger text-white mb-5" style="border-radius: 15px;">
    <div class="card-body">
        <h5>Saldo Anda</h5>
        <h2>Rp <?= number_format($balance, 0, ',', '.'); ?></h2>
        <a href="/dashboard" class="text-white mt-2 d-inline-block" style="text-decoration: underline;">Lihat Saldo</a>
    </div>
</div>