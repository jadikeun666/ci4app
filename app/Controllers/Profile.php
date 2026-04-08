<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;

class Profile extends BaseController
{
  public function index()
  {
    $model = new MahasiswaModel();

    $userId = session()->get('user_id');

    $data['mahasiswa'] = $model
        ->where('user_id', $userId)
        ->first();

    if(!$data['mahasiswa']){
      return view('profile_kosong');
    }

    return view('profile', $data);
  }

  public function edit()
  {
    $model = new \App\Models\MahasiswaModel();

    $userId = session()->get('user_id');

    $data['mahasiswa']=$model
      ->where('user_id', $userId)
      ->first();
    
    if (!$data['mahasiswa']){
      return redirect()->to('/profile')->with('error', 'Data Tidak Ditemukan');
      }
      return view('edit_profile', $data);
  }

    public function update()
    {
    $model = new \App\Models\MahasiswaModel();

    $userId = session()->get('user_id');

    // ambil data milik user
    $dataLama = $model->where('user_id', $userId)->first();

    if (!$dataLama) {
        return redirect()->to('/profile')->with('error', 'Data tidak valid');
    }

    $file = $this->request->getFile('foto');

    if ($file && $file->isValid()) {

        // hapus foto lama
        if ($dataLama['foto'] != 'default.png' && file_exists(FCPATH.'img/'.$dataLama['foto'])) {
            unlink(FCPATH.'img/'.$dataLama['foto']);
        }

        $namaFoto = $file->getRandomName();
        $file->move('img', $namaFoto);

    } else {
        $namaFoto = $dataLama['foto'];
    }

    $model->update($dataLama['id'], [
        'nama' => $this->request->getPost('nama'),
        'jurusan_id' => $this->request->getPost('jurusan_id'),
        'foto' => $namaFoto
    ]);

    return redirect()->to('/profile')->with('pesan', 'Profile berhasil diupdate');
    }

    public function changePassword()
    {
      return view('change_password');
    }

    public function updatePassword()
    {
      $userModel = new \App\Models\UserModel();

      $userId =  session()->get('user_id');

      $user = $userModel->find($userId);

      $passwordLama= $this->request->getPost('password_lama');
      $passwordBaru= $this->request->getPost('password_baru');
      $konfirmasi= $this->request->getPost('konfirmasi');
      

      //validasi password lama
      if (!password_verify($passwordLama, $user['password'])){
        return redirect()->back()->with('error','Password Lama Salah');
      }
      // validasi konfirmasi
      if ($passwordBaru !== $konfirmasi) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak cocok');
      }

    // hash password baru
      $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);

      $userModel->update($userId, [
        'password' => $hash
      ]);

      return redirect()->to('/profile')->with('pesan', 'Password berhasil diganti');

      }
}