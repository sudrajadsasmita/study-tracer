<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($result, String $message, String $token = null)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        if ($token != null) {
            $response['token'] = $token;
        }
        return response()->json($response, 200);
    }

    public function sendError(String $error, $errorMessage = [], int $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
