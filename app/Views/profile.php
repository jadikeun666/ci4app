<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php if(empty($mahasiswa)): ?>
    <?= $this->include('profile_kosong'); ?>
<?php else: ?>

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h3>👤 Profile Saya</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="<?= base_url('img/' . $mahasiswa['foto']); ?>"
                         class="img-fluid rounded-circle shadow"
                         style="width:180px;height:180px;object-fit:cover;">
                </div>

                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td>: <?= esc($mahasiswa['nama']); ?></td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td>: <?= esc($mahasiswa['nim']); ?></td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>: <?= esc($mahasiswa['jurusan_id']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection(); ?>