<?= $this->extend('layout/template_tailwind'); ?>
<?= $this->section('content'); ?>

<div class="max-w-6xl mx-auto mt-8">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-2xl font-bold text-gray-800">
                Daftar Mahasiswa
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Data mahasiswa beserta jurusan dan foto
            </p>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">NIM</th>
                        <th class="px-6 py-3 font-semibold">Jurusan</th>
                        <th class="px-6 py-3 font-semibold">Foto</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <?php foreach($mahasiswa as $m): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><?= esc($m['nama']); ?></td>
                        <td class="px-6 py-4"><?= esc($m['nim']); ?></td>
                        <td class="px-6 py-4"><?= esc($m['nama_jurusan']); ?></td>
                        <td class="px-6 py-4">
                            <img src="<?= base_url('img/' . $m['foto']); ?>" 
                                 alt="Foto Mahasiswa"
                                 class="w-24 h-24 object-cover rounded-lg shadow">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>