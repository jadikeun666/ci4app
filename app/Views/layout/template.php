<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="<?= base_url('css/stylemahasiswa.css'); ?>">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  

<style>
.pagination .page-link{
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
}
</style>
</head>
<body>
  

<div class="container mt-4">
<h1>Sistem Data Mahasiswa</h1>

<hr>
<?= $this->renderSection('content'); ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<hr>

<?= $this->renderSection('content'); ?>

</body>
</html>


