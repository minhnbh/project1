<?php

namespace App\Http\Controllers;

use EllipseSynergie\ApiResponse\Contracts\Response;
use JWTAuth;

class ApiController extends \App\Http\Controllers\Controller
{
    public function requiredAuthUser()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION']) || empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return $this->responseError('Token is required');
        }

        try {
            $this->token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
            JWTAuth::setToken($this->token);
            return JWTAuth::toUser();
        }
        catch (Exception $e) {
            return $this->responseError('token_invalid');
        }
    }

    protected function responseError($message, $code = null)
    {  
        return response()->json(['message' => $message, 'code' => $code ], 400);
    }
}
