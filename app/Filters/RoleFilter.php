<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    if(!session()->get('login')){
      return redirect()->to('\login');
    }

    if(in_array(session()->get('\role'), $arguments)){
      return redirect()->to('\mahasiswa');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    
  }
}


?>