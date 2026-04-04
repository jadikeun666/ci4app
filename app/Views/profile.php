<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<?php if(empty($mahasiswa)): ?>
    <?= $this->include('profile_kosong'); ?>
<?php else: ?>

<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4">
            <h3 class="text-2xl font-bold">👤 Profile Saya</h3>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="grid md:grid-cols-3 gap-8 items-center">
                
                <!-- Foto -->
                <div class="flex justify-center">
                    <img src="<?= base_url('img/' . $mahasiswa['foto']); ?>"
                         alt="Foto Profile"
                         class="w-44 h-44 rounded-full object-cover shadow-lg border-4 border-gray-100">
                </div>

                <!-- Data -->
                <div class="md:col-span-2">
                    <div class="space-y-4 text-gray-700">
                        <div class="flex border-b pb-2">
                            <span class="w-32 font-semibold">Nama</span>
                            <span>: <?= esc($mahasiswa['nama']); ?></span>
                        </div>

                        <div class="flex border-b pb-2">
                            <span class="w-32 font-semibold">NIM</span>
                            <span>: <?= esc($mahasiswa['nim']); ?></span>
                        </div>

                        <div class="flex border-b pb-2">
                            <span class="w-32 font-semibold">Jurusan</span>
                            <span>: <?= esc($mahasiswa['jurusan_id']); ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Button -->
            <div class="mt-8">
                <a href="/mahasiswa-list"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium px-6 py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition duration-300">
                   📋 Lihat Semua Mahasiswa
                </a>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection(); ?>