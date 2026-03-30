<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Mahasiswa extends ResourceController
{
    protected $modelName = 'App\Models\MahasiswaModel';
    protected $format    = 'json';

    public function index()
    {
        $data = $this->model->findAll();

        return successResponse($data, 'Data Mahasiswa Berhasil Diambil');
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return errorResponse('Data tidak ditemukan', 404);
        }

        return successResponse($data,'Detail Mahasiswa');
    }

    public function create()
    {

        $nama = $this->request->getPost('nama');
        if (!$nama) {
        return errorResponse('Nama wajib diisi', 400);
        }

        $nim = $this->request->getPost('nim');
        if (!$nim) {
        return errorResponse('NIM wajib diisi', 400);
        }

        $jurusan_id = $this->request->getPost('jurusan_id');
        if (!$jurusan_id) {
        return errorResponse('Jurusan wajib diisi', 400);
        }

        $file = $this->request->getFile('foto');
        if (!$file) {
        return errorResponse('Foto wajib diisi', 400);
        }

        if(!$file || !$file->isValid()) {
        return errorResponse('Foto wajib diisi', 400);
        }

    
        if (!$this->validate([
            'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]'
            ])) {
                return errorResponse($this->validator->getErrors(), 400);
                }



        $namaFoto = $file->getRandomName();
        $file->move(FCPATH . 'img', $namaFoto);

    $result = $this->model->insert([
        'nama'          => $nama,
        'nim'           => $nim,
        'jurusan_id'    => $jurusan_id,
        'foto'          => $namaFoto
        ]);
        if (!$result) {
            return errorResponse('Gagal insert', 500, $this->model->errors());
            }
            return successResponse(null, 'Data berhasil ditambahkan', 201);
    }

public function update($id = null)
{
    $dataLama = $this->model->find($id);

    if (!$dataLama) {
        return $this->failNotFound('Data tidak ditemukan');
    }

    $file = $this->request->getFile('foto');
    $path = FCPATH . 'img/';

    if ($file && $file->isValid() && $file->getError() == 0) {

        if(!$this->validate([
            'foto' => 'is_image[foto]|max_size[foto,2048]'
        ])) {
            return $this->fail($this->validator->getErrors());
        }

        if ($dataLama['foto'] != 'default.png' && file_exists($path . $dataLama['foto'])) {
            unlink($path . $dataLama['foto']);
        }

        $namaFoto = $file->getRandomName();
        $file->move($path, $namaFoto);

    } else {
        $namaFoto = $dataLama['foto'];
    }

    $this->model->update($id, [
        'nama' => $this->request->getPost('nama'),
        'nim' => $this->request->getPost('nim'),
        'jurusan_id' => $this->request->getPost('jurusan_id'),
        'foto' => $namaFoto
    ]);

    return successResponse(null, 'Data berhasil diupdate');
}

    public function delete($id = null)
    {
        $data = $this->model->find($id);

        if(!$data){
            return $this->failNotFound('Data Tidak Ditemukan');
        }

        if ($data['foto' ] != 'default.png'&& file_exists('/img'. $data['foto'])){
            unlink('img/'. $data['foto']);
        }
        $this->model->delete($id);

    return successResponse(null, 'Data berhasil dihapus');
    }
}