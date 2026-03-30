<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
  <h2 class = "mb-4">Audit Log</h2>

  <div class="card shadow">
    <div class="card-body">

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>User</th>
          <th>Aksi</th>
          <th>Deskripsi</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($log as $l): ?>
        <tr>
          <td><?= $l['user']; ?></td>
          <td>
            <span class="badge bg-primary">
              <?= $l['action']; ?>
            </span>
            <td><?= $l['description']; ?></td>
            <td><?= $l['created_at']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>

</div>

<?= $this->endSection(); ?>
