<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController
{
  protected $modelName = 'App\Models\UserModel';
  protected $format = 'json';

  public function login()
  {
    $data = $this->request->getJSON(true);

    $user = $this->model->where('username' , $data['username'])->first();

    if (!$user || !password_verify($data['password'], $user['password'])) {
      return errorResponse('Login gagal', 401);
    }

    $key = getenv('JWT_SECRET');

    $payload = [
      'iat'   => time(),
      'exp'   => time() + 7200,
      'username'  => $user['username'],
      'role'      => $user['role']
    ];

    $token = JWT::encode($payload, $key, 'HS256');

    return successResponse([
    'token' => $token
    ],
    'Login berhasil');
  }
}
?>