<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\ApiLogModel;

class ApiLogFilter implements FilterInterface
{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $_SERVER['REQUEST_START_TIME'] = microtime(true);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $logModel = new \App\Models\ApiLogModel();

        // hitung durasi
        $start = $_SERVER['REQUEST_START_TIME'] ?? microtime(true);
        $duration = (microtime(true) - $start) * 1000;

        $req = service('request');
        $res = service('response');

        $user = 'guest';
        if (property_exists($request, 'user') && isset($request->user->username)) {
            $user = $request->user->username;
        }

        $ip = $req->getIPAddress() ?: 'unknown';
        $status = $res->getStatusCode() ?? 200;

        if (!$ip) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }
        if (!$status) {
            $status = 200;
        }

        $logModel->insert([
            'method'      => strtoupper($req->getMethod()),
            'endpoint'    => $req->getUri()->getPath(),
            'ip_address'  => $ip,
            'user'        => $user,
            'status_code' => $status,
            'response_time' => round($duration, 3)
        ]);

    }
}