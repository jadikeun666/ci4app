<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;
use PHPUnit\Framework\TestStatus\Unknown;

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
      'user'          => $user['username'] ?? 'unknown',
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
    $log = new AuditLogModel();

    $log->insert([
      'user'        => session()->get('username'),
      'action'      => 'LOGOUT',
      'description' => 'User Logout'
    ]);
    
    session()->destroy();
    return redirect()->to('/login');
  }
  public function forgotPassword()
{
    return view('forgot_password');
}

public function sendResetLink()
{
    $emailInput = $this->request->getPost('email');

    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('email', $emailInput)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Email tidak ditemukan');
    }

    $token = bin2hex(random_bytes(32));

    $userModel->update($user['id'], [
        'reset_token' => $token,
        'token_expired' => date('Y-m-d H:i:s', strtotime('+1 hour'))
    ]);

    $link = base_url('/reset-password/' . $token);

    // 🔥 kirim email
    $email = \Config\Services::email();

    $email->setTo($emailInput);
    $email->setFrom('didu90nios81@gmail.com', 'Sistem CI4');
    $email->setSubject('Reset Password');

    $email->setMessage("
        <h3>Reset Password</h3>
        <p>Klik link berikut untuk reset password:</p>
        <a href='$link'>$link</a>
        <br><br>
        <small>Link berlaku 1 jam</small>
    ");

    if (!$email->send()) {
        dd($email->printDebugger(['headers']));
    }

    return redirect()->back()->with('pesan', 'Link reset dikirim ke email');
}

public function resetPassword($token)
{
    $userModel = new \App\Models\UserModel();

    $user = $userModel->where('reset_token', $token)->first();

    if (!$user) {
        return redirect()->to('/login')->with('error', 'Token tidak valid');
    }

    if (strtotime($user['token_expired']) < time()) {
        return redirect()->to('/login')->with('error', 'Token expired');
    }

    return view('reset_password', ['token' => $token]);
}


public function updateResetPassword()
{
    $token = $this->request->getPost('token');

    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('reset_token', $token)->first();

    if (!$user) {
        return redirect()->to('/login')->with('error', 'Token tidak valid');
    }

    if (strtotime($user['token_expired']) < time()) {
        return redirect()->to('/login')->with('error', 'Token expired');
    }

    $passwordBaru = $this->request->getPost('password');

    $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);

    $userModel->update($user['id'], [
        'password' => $hash,
        'reset_token' => null,
        'token_expired' => null
    ]);

    return redirect()->to('/login')->with('pesan', 'Password berhasil direset');
}

}

?>