<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h2>Edit Mahasiswa</h2>

<form action="<?= base_url('mahasiswa/update/'.$mahasiswa['id']); ?>" 
      method="post" 
      enctype="multipart/form-data">

<?= csrf_field(); ?>

Nama
<input type="text" name="nama" value="<?= esc($mahasiswa['nama']); ?>">

<br>

NIM
<input type="text" name="nim" value="<?= esc($mahasiswa['nim']); ?>">

<br>

Jurusan
<select name="jurusan_id">
      <option value="">-- Pilih Jurusan --</option>

      <?php foreach($jurusan as $j): ?>
            <option value="<?= $j['id']; ?>"
                  <?= ($j['id'] == $mahasiswa['jurusan_id']) ? 'selected' : ''; ?>>
                  <?= $j['nama_jurusan']; ?>
            </option>
      <?php endforeach; ?>
</select>

<br>

Foto
<input type="file" name="foto">

<br>

<!-- SIMPAN FOTO LAMA -->
<input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto']; ?>">

<br>

<button type="submit">Update</button>

</form>

<?= $this->endSection(); ?>