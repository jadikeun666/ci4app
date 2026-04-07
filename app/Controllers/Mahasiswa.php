<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\AuditLogModel;

class Mahasiswa extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/profile');
            }

        $model = new MahasiswaModel();

        $keyword = $this->request->getGet('keyword');

        $data = [
            'mahasiswa' => $model->getMahasiswa($keyword)->paginate(5),
            'pager'     => $model->pager,
            'keyword'   => $keyword
        ];

        return view('mahasiswa', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/profile');
            }


        $db = \Config\Database::connect();
        $jurusan = $db->table('jurusan')
                      ->get()
                      ->getResultArray();

        $data['jurusan'] = $jurusan;

        return view('tambah_mahasiswa', $data);
    }

    public function save()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/profile');
            }
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'nim' => 'required',
            'jurusan_id' => 'required',
            'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]'
        ])) {
            return redirect()->to('/mahasiswa/create')
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $model = new MahasiswaModel();

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('img', $namaFoto);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'foto' => $namaFoto,
            'user_id' => session()->get('user_id')
        ];

        $model->insert($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        $log = new AuditLogModel();

        $log->insert([
            'user'          => session()->get('username'),
            'action'        => 'CREATE',
            'description'   => 'Menambahkan data mahasiswa: '.$this->request->getPost('nama')
        ]);

        return redirect()->to('/mahasiswa');
    }

    public function edit($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/profile');
            }


        $model = new MahasiswaModel();

        $db = \Config\Database::connect();
        $jurusan = $db->table('jurusan')->get()->getResultArray();

        $data['mahasiswa'] = $model->find($id);
        $data['jurusan'] = $jurusan;

        return view('edit_mahasiswa', $data);
    }

    public function update($id = null)
{
    $model = new MahasiswaModel();

    $role   = session()->get('role');
    $userId = session()->get('user_id');

    // Ambil data berdasarkan role
    if ($role == 'admin') {
        $dataLama = $model->find($id);
    } else {
        $dataLama = $model->where('user_id', $userId)->first();
    }

    if (!$dataLama) {
        return redirect()->to('/profile')->with('error', 'Data tidak ditemukan');
    }

    // Validasi (beda admin vs user)
    $rules = [
        'nama' => 'required|min_length[3]',
        'jurusan_id' => 'required'
    ];

    if ($role == 'admin') {
        $rules['nim'] = 'required';
    }

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput();
    }

    // Upload foto
    $fileFoto = $this->request->getFile('foto');

    if ($fileFoto && $fileFoto->isValid() && $fileFoto->getError() != 4) {

        if (!empty($dataLama['foto']) && file_exists('img/'.$dataLama['foto'])) {
            unlink('img/'.$dataLama['foto']);
        }

        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('img', $namaFoto);

    } else {
        $namaFoto = $dataLama['foto'];
    }

    // Data update dibatasi
    if ($role == 'admin') {
        $dataUpdate = [
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'foto' => $namaFoto
        ];
    } else {
        $dataUpdate = [
            'nama' => $this->request->getPost('nama'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'foto' => $namaFoto
        ];
    }

    $model->update($dataLama['id'], $dataUpdate);

    // Audit log
    $log = new AuditLogModel();
    $log->insert([
        'user' => session()->get('username'),
        'action' => 'UPDATE',
        'description' => 'Update data ID: '.$dataLama['id']
    ]);

    return redirect()->to($role == 'admin' ? '/mahasiswa' : '/profile')
                     ->with('pesan', 'Data berhasil diupdate');
                     }

    public function delete($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/profile');
            }


        $model = new MahasiswaModel();

        $data = $model->find($id);

        // hapus file foto
        if ($data['foto']) {
            unlink('img/' . $data['foto']);
        }

        $model->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus');

        $log = new AuditLogModel();
        $log->insert([
            'user'          => session()->get('username'),
            'action'        => 'DELETE',
            'description'   => 'Hapus data ID: '.$id
        ]);

        return redirect()->to('/mahasiswa');
    }

    public function list()
    {
        if (!session()->get('login')) {
            return redirect()->to('/login');
            }
        $model = new MahasiswaModel();

        $data=[
            'mahasiswa' => $model->getMahasiswa()->findAll()
        ];

        return view('mahasiswa_list', $data);
    }
}