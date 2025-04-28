<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container" style="max-width: 600px; margin: 50px auto; text-align: center;">
    <div style="position: relative;">
        <img src="<?= isset($profile['profile_image']) ? $profile['profile_image'] : '/Web Assets/Profile Photo.png' ?>" 
             alt="Profile Picture" 
             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
        <a href="#" style="position: absolute; bottom: 0; right: 10px; background: #fff; border-radius: 50%; padding: 5px;">
            ✏️
        </a>
    </div>

    <h2 style="margin-top: 20px;"><?= esc($profile['first_name'] . ' ' . $profile['last_name']) ?></h2>

    <!-- Form Update Profile -->
    <form action="<?= site_url('profile/update') ?>" method="post" style="margin-top: 30px;">
        <?= csrf_field() ?>

        <div style="text-align: left; margin-bottom: 20px;">
            <label>Email</label>
            <input type="text" name="email" value="<?= esc($profile['email']) ?>" readonly
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="text-align: left; margin-bottom: 20px;">
            <label>Nama Depan</label>
            <input type="text" name="first_name" value="<?= esc($profile['first_name']) ?>"
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="text-align: left; margin-bottom: 30px;">
            <label>Nama Belakang</label>
            <input type="text" name="last_name" value="<?= esc($profile['last_name']) ?>"
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background-color: #f32b19; color: white; border: none; border-radius: 5px; font-weight: bold;">
            Simpan
        </button>
    </form>
<?= $this->endSection() ?>
