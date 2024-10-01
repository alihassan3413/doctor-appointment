<?php

namespace App\Traits;

trait ApiResponse 
{
    protected function ok($message, $data = [], $token = null)
    {
        return $this->success($message, $data, 200, $token);  // Pass a default status code
    }

    protected function success($message, $data = [], $statusCode = 200, $token = null)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'token' => $token,
            'success' => true
        ], $statusCode);
    }

    public function error($errors = [], $statusCode = 400) // Set default status code to 400
    {
        if (is_string($errors)) {
            return response()->json(
                [
                    'message' => $errors,
                    'success' => false
                ],
                $statusCode 
            );
        }

        
        return response()->json([
            'errors' => $errors
        ], $statusCode ?? 400); 
    }
}
