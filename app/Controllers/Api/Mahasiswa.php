<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Mahasiswa extends ResourceController
{
    protected $modelName = 'App\Models\MahasiswaModel';
    protected $format    = 'json';

    private function getUserFromToken()
    {
        $header = $this->request->getHeaderLine('Authorization');

        if (!$header) {
            return null;
        }

        $token = str_replace('Bearer ', '', $header);

        try {
            $key = getenv('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            $decodedArray = (array) $decoded;

            // pastikan ada id & role
            if (!isset($decodedArray['id']) || !isset($decodedArray['role'])) {
                return null;
            }

            return $decodedArray;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function index()
    {
        $user = $this->getUserFromToken();

        if (!$user) {
            return errorResponse('Token tidak valid', 401);
        }

        $keyword = $this->request->getVar('keyword');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5;

        $this->model
            ->select('mahasiswa.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = mahasiswa.jurusan_id');

        if ($keyword) {
            $this->model
                ->groupStart()
                ->like('nama', $keyword)
                ->orLike('nim', $keyword)
                ->orLike('jurusan.nama_jurusan', $keyword)
                ->groupEnd();
        }

        $data = $this->model->paginate($perPage, 'default', $page);
        $pager = $this->model->pager;

        return successResponse([
            'mahasiswa' => $data,
            'pagination' => [
                'current_page' => $pager->getCurrentPage(),
                'total_page' => $pager->getPageCount(),
                'per_page' => $perPage,
                'total_data' => $pager->getTotal()
            ]
        ], 'Data Mahasiswa Berhasil Diambil');
    }

    public function show($id = null)
    {
        $user = $this->getUserFromToken();

        if (!$user) {
            return errorResponse('Token tidak valid', 401);
        }

        $data = $this->model->find($id);

        if (!$data) {
            return errorResponse('Data tidak ditemukan', 404);
        }

        return successResponse($data, 'Detail Mahasiswa');
    }

    public function create()
    {
        $user = $this->getUserFromToken();

        // hanya admin
        if (!$user || $user['role'] !== 'admin') {
            return errorResponse('Akses ditolak (admin only)', 403);
        }

        $nama = $this->request->getPost('nama');
        $nim = $this->request->getPost('nim');
        $jurusan_id = $this->request->getPost('jurusan_id');
        $file = $this->request->getFile('foto');

        if (!$nama) return errorResponse('Nama wajib diisi', 400);
        if (!$nim) return errorResponse('NIM wajib diisi', 400);
        if (!$jurusan_id) return errorResponse('Jurusan wajib diisi', 400);
        if (!$file || !$file->isValid()) return errorResponse('Foto wajib diisi', 400);

        if (!$this->validate([
            'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]'
        ])) {
            return errorResponse($this->validator->getErrors(), 400);
        }

        $namaFoto = $file->getRandomName();
        $file->move(FCPATH . 'img', $namaFoto);

        $result = $this->model->insert([
            'nama'       => $nama,
            'nim'        => $nim,
            'jurusan_id' => $jurusan_id,
            'foto'       => $namaFoto,
            'user_id'    => $user['id']
        ]);

        if (!$result) {
            return errorResponse('Gagal insert', 500, $this->model->errors());
        }

        return successResponse(null, 'Data berhasil ditambahkan', 201);
    }

    public function update($id = null)
    {
        $user = $this->getUserFromToken();

        if (!$user) {
            return errorResponse('Token tidak valid', 401);
        }

        $dataLama = $this->model->find($id);

        if (!$dataLama) {
            return errorResponse('Data tidak ditemukan', 404);
        }

        // 🔥 ADMIN atau PEMILIK DATA
        if (
            $user['role'] !== 'admin' &&
            $user['id'] != $dataLama['user_id']
        ) {
            return errorResponse('Tidak boleh edit data orang lain', 403);
        }

        $input = $this->request->getPost();
        if (empty($input)) {
            $input = $this->request->getRawInput();
        }

        $nama = $input['nama'] ?? $dataLama['nama'];
        $nim = $input['nim'] ?? $dataLama['nim'];
        $jurusan_id = $input['jurusan_id'] ?? $dataLama['jurusan_id'];

        // 🔥 USER tidak boleh ubah field tertentu
        if ($user['role'] !== 'admin') {
            $nim = $dataLama['nim'];
            $jurusan_id = $dataLama['jurusan_id'];
        }

        $file = $this->request->getFile('foto');
        $path = FCPATH . 'img/';

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!$this->validate([
                'foto' => 'is_image[foto]|max_size[foto,2048]'
            ])) {
                return errorResponse($this->validator->getErrors(), 400);
            }

            if (
                $dataLama['foto'] != 'default.png' &&
                file_exists($path . $dataLama['foto'])
            ) {
                unlink($path . $dataLama['foto']);
            }

            $namaFoto = $file->getRandomName();
            $file->move($path, $namaFoto);

        } else {
            $namaFoto = $dataLama['foto'];
        }

        $this->model->update($id, [
            'nama'       => $nama,
            'nim'        => $nim,
            'jurusan_id' => $jurusan_id,
            'foto'       => $namaFoto
        ]);

        return successResponse(null, 'Data berhasil diupdate');
    }

    public function delete($id = null)
    {
        $user = $this->getUserFromToken();

        // hanya admin
        if (!$user || $user['role'] !== 'admin') {
            return errorResponse('Akses ditolak (admin only)', 403);
        }

        $data = $this->model->find($id);

        if (!$data) {
            return errorResponse('Data tidak ditemukan', 404);
        }

        $path = FCPATH . 'img/';

        if ($data['foto'] != 'default.png' && file_exists($path . $data['foto'])) {
            unlink($path . $data['foto']);
        }

        $this->model->delete($id);

        return successResponse(null, 'Data berhasil dihapus');
    }
}