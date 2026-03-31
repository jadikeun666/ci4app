<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiLogModel extends Model
{
    protected $table = 'api_log';
    protected $allowedFields = [
        'method',
        'endpoint',
        'ip_address',
        'user',
        'status_code'
    ];
}