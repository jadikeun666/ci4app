<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
  public function login()
  {
    return view('login');
  }

public function processLogin()
{
    $model = new \App\Models\UserModel();
    $throttler = service('throttler');

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // 🔑 key kombinasi (IP + username)
    $key = md5 ($this->request->getIPAddress() . '_' . $username);

    // 🚫 CEK LIMIT
    if (!$throttler->check($key, 5, 300)) {
        return redirect()->to('/login')
            ->with('error', 'Terlalu banyak percobaan login. Coba lagi dalam 5 menit.');
    }

    $user = $model->where('username', $username)->first();

    // ✅ LOGIN BERHASIL
    if ($user && password_verify($password, $user['password'])) {

        session()->set('login', true);
        session()->set('username', $user['username']);
        session()->set('user_id', $user['id']);
        session()->set('role', $user['role']);

        
        if ($user['role'] == 'admin'){
          return redirect()->to('/mahasiswa');
        } else{
          return redirect()->to('/profile');
        }
    }

    //  LOGIN GAGAL
    session()->setFlashdata('error', 'Username atau Password salah');
    

    $log = new \App\Models\AuditLogModel();
    $log->insert([
      'user'          => $user['username'],
      'action'        => 'LOGIN',
      'description'   => 'User login'
    ]);

    return redirect()->to('/login');
}

  public function register()
  {
    return view('register');
  }

  public function processRegister()
  {
    $model = new UserModel();

    $model->insert([
      'username'    => $this->request->getPost('username'),
      'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
      'role'        => 'user'
    ]);

    return redirect()->to('/login');
  }

  public function logout()
  {
    $log = new App\Models\AuditLogModel();

    $log->insert([
      'user'        => session()->get('username'),
      'action'      => 'LOGOUT',
      'description' => 'User Logout'
    ]);
    
    session()->destroy();
    return redirect()->to('/login');
  }
}

?>