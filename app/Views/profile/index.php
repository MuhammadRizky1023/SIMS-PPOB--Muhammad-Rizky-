<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<div class="container text-center py-4">

  <!-- Flash message -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <!-- Form Update Profile -->
  <form action="/profile/update" method="post" id="formUpdateProfile">
    <?= csrf_field() ?>
    
    <!-- Foto Profil -->
    <div class="mb-3 position-relative d-inline-block">
      <img src="<?= esc($profile['profile_image']) ?>" alt="Profile Image" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
      
      <label for="imageUpload" class="position-absolute bottom-0 end-0 bg-white border rounded-circle p-1 shadow-sm" style="cursor:pointer;">
        <i class="bi bi-pencil-fill"></i>
      </label>

      <!-- Upload Foto Profil -->
      <form id="imageUploadForm" action="/profile/image" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="file" id="imageUpload" name="profile_image" class="d-none" accept="image/*" onchange="document.getElementById('imageUploadForm').submit();">
      </form>
    </div>

    <!-- Nama dan Email -->
    <h4 class="fw-bold"><?= esc($profile['first_name'] . ' ' . $profile['last_name']) ?></h4>

    <div class="text-start mx-auto" style="max-width: 400px;">
      <div class="mb-3">
        <label>Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control" value="<?= esc($profile['email']) ?>" readonly>
        </div>
      </div>

      <div class="mb-3">
        <label>Nama Depan</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="first_name" class="form-control" value="<?= esc($profile['first_name']) ?>" readonly>
        </div>
      </div>

      <div class="mb-3">
        <label>Nama Belakang</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="last_name" class="form-control" value="<?= esc($profile['last_name']) ?>" readonly>
        </div>
      </div>

      <!-- Tombol Edit -->
      <div class="d-grid gap-2">
        <button type="button" class="btn btn-danger" id="editButton">Edit Profil</button>
        <a href="/logout" class="btn btn-outline-danger">Logout</a>
      </div>
    </div>
  </form>
</div>

<!-- JavaScript Edit Profil -->
<script>
  const editButton = document.getElementById('editButton');
  const form = document.getElementById('formUpdate
