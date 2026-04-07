<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<div class="max-w-3xl mx-auto mt-8">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4">
            <h2 class="text-2xl font-bold">✏️ Edit Profile</h2>
        </div>

        <!-- Form -->
        <form action="/profile/update" method="post" enctype="multipart/form-data" class="p-8 space-y-6">
            <?= csrf_field(); ?>

            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama
                </label>
                <input type="text" 
                       name="nama" 
                       value="<?= esc($mahasiswa['nama']); ?>"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Jurusan Dropdown -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jurusan
                </label>
                <select name="jurusan_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="1" <?= $mahasiswa['jurusan_id'] == 1 ? 'selected' : ''; ?>>Teknik Informatika</option>
                    <option value="2" <?= $mahasiswa['jurusan_id'] == 2 ? 'selected' : ''; ?>>Perpajakan</option>
                    <option value="3" <?= $mahasiswa['jurusan_id'] == 3 ? 'selected' : ''; ?>>Teknik Pertambangan</option>
                    <option value="4" <?= $mahasiswa['jurusan_id'] == 4 ? 'selected' : ''; ?>>Kelautan</option>
                    <option value="5" <?= $mahasiswa['jurusan_id'] == 5 ? 'selected' : ''; ?>>Agroteknologi</option>
                    <option value="6" <?= $mahasiswa['jurusan_id'] == 6 ? 'selected' : ''; ?>>Agronomi</option>
                    <option value="7" <?= $mahasiswa['jurusan_id'] == 7 ? 'selected' : ''; ?>>Manajemen</option>
                </select>
            </div>

            <!-- Foto Lama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto Saat Ini
                </label>
                <img src="<?= base_url('img/'.$mahasiswa['foto']); ?>" 
                     alt="Foto Profile"
                     class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-gray-100">
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload Foto Baru
                </label>
                <input type="file" 
                       name="foto"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50">
            </div>

            <!-- Button -->
            <div class="pt-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium px-6 py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition duration-300">
                    💾 Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>