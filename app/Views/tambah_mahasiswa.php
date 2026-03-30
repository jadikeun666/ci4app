<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">

  <h2 class="mb-4">Tambah Data Mahasiswa</h2>

  <?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach(session()->getFlashdata('errors') as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card shadow">
    <div class="card-body">

      <form action="<?= base_url('mahasiswa/save'); ?>" method="post" enctype="multipart/form-data">

        <?= csrf_field(); ?>

        <!-- Nama -->
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="<?= esc(old('nama')); ?>">
        </div>

        <!-- NIM -->
        <div class="mb-3">
          <label class="form-label">NIM</label>
          <input type="text" name="nim" class="form-control" value="<?= old('nim'); ?>">
        </div>

        <!-- Jurusan -->
        <div class="mb-3">
          <label class="form-label">Jurusan</label>
          <select name="jurusan_id" class="form-select">
            <option value="" disabled selected>-- Pilih Jurusan --</option>

            <?php foreach($jurusan as $j): ?>
              <option value="<?= $j['id']; ?>">
                <?= $j['nama_jurusan']?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Foto -->
        <div class="mb-3">
          <label class="form-label">Foto</label>
          <input type="file" name="foto" class="form-control">
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-primary">
          Simpan
        </button>

        <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary">
          Kembali
        </a>

      </form>

    </div>
  </div>

</div>

<?= $this->endSection(); ?>