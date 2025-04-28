<h4 class="mb-3">Layanan</h4>
<div class="row text-center mb-5">
    <?php foreach ($services as $service): ?>
        <div class="col-4 col-md-2 mb-3">
            <form method="POST" action="/transaction/pay">
                <?= csrf_field() ?>
                <input type="hidden" name="service_code" value="<?= esc($service['service_code']); ?>">
                <button type="submit" class="border-0 bg-transparent p-3 w-100">
                    <div class="p-3 bg-light rounded-3 shadow-sm">
                        <img src="<?= esc($service['service_icon']); ?>" class="img-fluid mb-2" style="height: 40px;" alt="<?= esc($service['service_name']); ?>">
                        <p class="small mb-0"><?= esc($service['service_name']); ?></p>
                    </div>
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
