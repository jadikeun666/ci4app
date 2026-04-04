<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php if(session()->getFlashdata('pesan')): ?>

  <div>
    <?= session()->getFlashdata('pesan'); ?>
</div>
<?php endif; ?>


<form method="get" action="<?= base_url('mahasiswa'); ?>">
  <input type ="text" name="keyword" 
  value="<?= $keyword ?? '' ?>" 
  placeholder="cari mahasiswa...">
  <button type="submit">Search</button>
</form>
<br>

<?php if(session()->get('role') == 'admin'):?>
<a href="<?= base_url('mahasiswa/create'); ?>" class="btn btn-primary">
  Tambah Data</a>


<?php endif; ?>
  <br><br>



<table class="table table-bordered table-stripted">

<tr>
<th>Nama</th>
<th>NIM</th>
<th>Jurusan</th>
<th>Foto</th>

<?php if(session()->get('role') == 'admin'):?>
<th>Aksi</th>
<?php endif; ?>
</tr>

<?php foreach($mahasiswa as $m): ?>

<tr>

<td><?= esc($m['nama']); ?></td>
<td><?= esc($m['nim']); ?></td>
<td><?= esc($m['nama_jurusan']); ?></td>
<td>
  <img src="<?= base_url('img/' .$m['foto']); ?>" width="100">
</td>


<?php if(session()->get('role') == 'admin'): ?>
<td>
    <a href="<?= base_url('mahasiswa/edit/'.$m['id']); ?>" class="btn btn-warning btn-sm">Edit</a>

    <a href="<?= base_url('mahasiswa/delete/'.$m['id']); ?>"
    onclick="return confirm('Hapus data?')"
    class="btn btn-danger btn-sm">Delete</a>
</td>
<?php endif; ?>



</tr>

<?php endforeach; ?>

</table>
<?= $pager->links('default', 'bootstrap'); ?>

<?= $this->endSection(); ?>