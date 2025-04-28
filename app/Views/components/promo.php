<h4 class="mb-3">Temukan Promo Menarik</h4>
<div class="row">
    <?php foreach ($banners as $banner): ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="<?= esc($banner['banner_image']); ?>" class="card-img-top rounded-4" alt="Promo Banner" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($banner['banner_name']); ?></h5>
                    <p class="card-text"><?= esc($banner['description']); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
