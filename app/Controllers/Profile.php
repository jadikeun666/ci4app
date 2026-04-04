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
}


?>