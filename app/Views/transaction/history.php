<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="card bg-danger text-white p-4 mb-4">
        <p class="mb-1">Saldo Anda</p>
        <h3 class="fw-bold">Rp <?= $showBalance ? number_format($balance, 0, ',', '.') : '••••••••' ?></h3>
        <small>
            <a href="<?= base_url('toggle-saldo-visibility') ?>" class="text-white text-decoration-underline">
                <?= $showBalance ? 'Sembunyikan' : 'Lihat Saldo' ?>
            </a>
        </small>
    </div>

    <h5 class="fw-bold mb-3">Semua Transaksi</h5>

    <!-- Filter Bulan -->
    <div class="d-flex mb-4 flex-wrap gap-2">
        <?php foreach ($months as $month): ?>
            <a href="<?= base_url('transaction/history?month=' . $month['value']) ?>" 
               class="<?= $selectedMonth == $month['value'] ? 'fw-bold' : 'text-muted' ?>">
                <?= $month['label'] ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- List Transaksi -->
    <?php if (empty($transactions)): ?>
        <p class="text-center text-muted mt-5">Maaf tidak ada histori transaksi saat ini</p>
    <?php else: ?>
        <div class="list-group mb-4">
            <?php foreach ($transactions as $trx): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 <?= $trx['amount'] > 0 ? 'text-success' : 'text-danger' ?>">
                            <?= $trx['amount'] > 0 ? '+' : '-' ?> Rp<?= number_format(abs($trx['amount']), 0, ',', '.') ?>
                        </h5>
                        <small class="text-muted"><?= date('d F Y H:i', strtotime($trx['created_at'])) ?> WIB</small>
                    </div>
                    <small class="text-muted"><?= esc($trx['description']) ?></small>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Show More -->
        <?php if ($hasMore): ?>
            <div class="text-center mb-5">
                <a href="<?= base_url('transaction/history?offset=' . $nextOffset) ?>" class="text-danger">Show more</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
