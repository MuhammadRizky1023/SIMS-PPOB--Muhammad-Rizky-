<!-- Profile Section -->
<div class="d-flex align-items-center mb-4">
    <img src="<?= esc($profile['profile_image'] ?? '/Website AssetsProfile Photo.png'); ?>" class="rounded-circle" width="80" height="80" alt="Profile Image">
    <div class="ms-3">
        <h5 class="mb-1">Selamat datang,</h5>
        <h3><?= esc($profile['first_name']); ?> <?= esc($profile['last_name']); ?></h3>
    </div>
</div>