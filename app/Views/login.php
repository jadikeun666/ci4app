<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5" style="max-width: 400px;">

    <h2 class="text-center mb-4">Login</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/login'); ?>" method="post">

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

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="<?= base_url('/register'); ?>">Belum punya akun? Register</a>
    </div>

    <div class="text-center mt-2">
    <a href="<?= base_url('/forgot-password'); ?>" 
       class="text-sm text-blue-500 hover:underline">
       Lupa Password?
    </a>
</div>

</div>

<?= $this->endSection(); ?>