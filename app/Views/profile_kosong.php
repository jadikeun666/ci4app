<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow border-0 rounded-4 text-center">
                <div class="card-body p-5">
                    <h2 class="text-secondary mb-3">📄 Profile Belum Tersedia</h2>

                    <p class="text-muted">
                        Data mahasiswa untuk akun yang sedang login belum tersedia.
                    </p>

                    <p class="text-muted">
                        Silakan hubungi admin atau lengkapi data profile terlebih dahulu.
                    </p>

                    <a href="<?= base_url('/'); ?>" class="btn btn-primary mt-3">
                        ⬅ Kembali ke Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>