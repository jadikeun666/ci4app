<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5" style="max-width: 400px;">

    <h2 class="text-center mb-4">Register</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/register'); ?>" method="post">

    <?= csrf_field(); ?>

        <div class="mb-3">
            <input type="text" 
                   name="username" 
                   class="form-control" 
                   placeholder="Username" 
                   required>
        </div>

        <div class="mb-3">
            <input type="password" 
                   name="password" 
                   class="form-control" 
                   placeholder="Password" 
                   required>
        </div>

        <div class="mb-3">
          <input type="password" 
          name="password_confirm" 
          class="form-control" 
          placeholder="Konfirmasi Password">
      </div>

        <button type="submit" class="btn btn-success w-100">
            Register
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="<?= base_url('/login'); ?>">Sudah punya akun? Login</a>
    </div>

</div>

<?= $this->endSection(); ?>