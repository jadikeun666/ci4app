<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-4">
            <h2 class="text-2xl font-bold">🔒 Ganti Password</h2>
            <p class="text-sm opacity-90">Silakan masukkan password lama dan password baru</p>
        </div>

        </div>

<!-- 🔔 NOTIFIKASI -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="mx-6 mt-4 bg-red-500 text-white px-4 py-3 rounded-xl shadow">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan')): ?>
    <div class="mx-6 mt-4 bg-green-500 text-white px-4 py-3 rounded-xl shadow">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>


        <!-- Form -->
        <form action="<?= base_url('/profile/update-password'); ?>" method="post" class="p-8 space-y-6">
            <?= csrf_field(); ?>

            <!-- Password Lama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Lama
                </label>
                <input type="password"
                       name="password_lama"
                       placeholder="Masukkan password lama"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none transition duration-300"
                       required>
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Baru
                </label>
                <input type="password"
                       name="password_baru"
                       placeholder="Masukkan password baru"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none transition duration-300"
                       required>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input type="password"
                       name="konfirmasi"
                       placeholder="Ulangi password baru"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none transition duration-300"
                       required>
            </div>

            <!-- Button -->
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition duration-300">
                    🔒 Simpan Password
                </button>

                <a href="<?= base_url('/profile'); ?>"
                   class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>