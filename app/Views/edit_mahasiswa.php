<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">
        Edit Mahasiswa
    </h2>

    <form action="<?= base_url('mahasiswa/update/'.$mahasiswa['id']); ?>" 
          method="post" 
          enctype="multipart/form-data"
          class="space-y-5">

        <?= csrf_field(); ?>

        <!-- Nama -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama
            </label>
            <input type="text" 
                   name="nama" 
                   value="<?= esc($mahasiswa['nama']); ?>"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- NIM -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                NIM
            </label>
            <input type="text" 
                   name="nim" 
                   value="<?= esc($mahasiswa['nim']); ?>"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Jurusan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jurusan
            </label>
            <select name="jurusan_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Jurusan --</option>

                <?php foreach($jurusan as $j): ?>
                    <option value="<?= $j['id']; ?>"
                        <?= ($j['id'] == $mahasiswa['jurusan_id']) ? 'selected' : ''; ?>>
                        <?= $j['nama_jurusan']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Foto -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload Foto Baru
            </label>
            <input type="file" 
                   name="foto"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
        </div>

        <!-- Preview Foto Lama -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto Saat Ini
            </label>
            <img src="<?= base_url('img/'.$mahasiswa['foto']); ?>" 
                 alt="Foto Mahasiswa"
                 class="w-32 h-32 object-cover rounded-lg shadow">
        </div>

        <!-- Foto lama -->
        <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto']; ?>">

        <!-- Button -->
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>

            <a href="<?= base_url('mahasiswa'); ?>"
               class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>