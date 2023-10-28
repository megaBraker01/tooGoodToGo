<?php


namespace App\Http\Response;


class ApiResponse {
    
    /**
     * 
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return type
     */
    public static function success($data = [], string $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'statusCode' => $statusCode,
            'error' => false,
            'data' => $data,
        ], $statusCode);
    }
    
    /**
     * 
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return type
     */
    public static function error($data = [], string $message = 'Error', int $statusCode = 500)
    {
        return response()->json([
            'message' => $message,
            'statusCode' => $statusCode,
            'error' => true,
            'data' => $data,
        ], $statusCode);
    }
    
}
