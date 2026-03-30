<?php

namespace App\Controllers;

use App\Models\AuditLogModel;

class Log extends BaseController
{
  public function index()
  {
    $model = new AuditLogModel();

    $data['log'] = $model
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('log', $data);
  }
}

?>