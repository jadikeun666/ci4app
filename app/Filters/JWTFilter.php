<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $header = $request->getHeaderLine('Authorization');

    if (!$header){
      return service('response')->setJSON([
        'message'   => 'Token tidak Ditemukan'
      ])->setStatusCode(401);
    }
    $parts = explode(' ', $header);

    if (count($parts) !== 2) {
        return service('response')->setJSON([
            'message' => 'Format token salah'
        ])->setStatusCode(401);
    }

    $token = $parts[1];

    try{
      $key    = getenv('JWT_SECRET');
      $decoded= \Firebase\JWT\JWT::decode($token, new Key($key, 'HS256'));

      $request->user = $decoded;

      if ($arguments) {
        if (!in_array($decoded->role, $arguments)){
          return service('response')->setJSON([
            'message' => 'Akses ditolak (role tidak sesuai)'
          ])->setStatusCode(403);
        }
      }

    } catch (\Exception $e) {
      return service('response')->setJSON([
        'message' => 'Token Tidak Valid'
      ])->setStatusCode(401);
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
?>

