<?php

namespace App\Http\Traits;

trait ApiResponser
{
  protected function successResponse($data, $code){
    return response()->json([
      'status' => true,
      'message' => 'Get request has been successfully completed.',
      'data' => $data,
    ], $code);
  }

  protected function errorResponse($code, $message){
    return response()->json([
      'status' => false,
      'message' => $message
    ], $code);
  }

}