<?php

function successResponse($data = null, $message = 'Success' , $code= '200')
{
  return service('response')->setJSON([
    'status'  => true,
    'message' => $message,
    'data'=> $data
  ])->setStatusCode($code);
}

function errorResponse($message = 'Error', $code = 400, $errors = null)
{
  return service('response')->setJSON([
    'status' => false,
    'message'=> $message,
    'errors'=> $errors
  ])->setStatusCode($code);
}
?>