<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-5">
            <h2 class="text-2xl font-semibold">🔑 Lupa Password</h2>
            <p class="text-sm text-blue-100 mt-1">
                Masukkan email untuk menerima link reset password
            </p>
        </div>

        <!-- Body -->
        <form action="<?= base_url('/send-reset-link'); ?>" method="post" class="p-6 space-y-5">
            <?= csrf_field(); ?>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Email
                </label>
                <input type="email"
                       name="email"
                       placeholder="Masukkan email"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-300"
                       required>
            </div>

            <!-- Button -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white font-medium py-3 rounded-xl shadow-sm hover:bg-blue-700 transition duration-300">
                📩 Kirim Link Reset
            </button>

            <!-- Back -->
            <div class="text-center">
                <a href="<?= base_url('/login'); ?>"
                   class="text-sm text-gray-500 hover:text-blue-600 transition duration-300">
                    ← Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>