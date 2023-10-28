<?php


namespace App\Http\Response;

/**
 * @OA\Schema(
 *   schema="ApiResponse",
 *   title="ApiResponse",
 *   description="ApiResponse model",
 *   type="object",
 *   @OA\Property (property="message", type="string", example="success"),
 *   @OA\Property (property="status_code", type="number", example="200"),
 *   @OA\Property (property="errors", type="boolean", example="false"),
 *   @OA\Property (property="data", type="array|object", example="[]|{}"),
 *   example={"message": "success", "status_code": 200, "errors": false, "data": "[]|{}"}
 * )
 * 
 * @OA\Schema(
 *   schema="ApiResponseError",
 *   title="ApiResponseError",
 *   description="ApiResponseError model",
 *   type="object",
 *   @OA\Property (property="message", type="string", example="error"),
 *   @OA\Property (property="status_code", type="number", example="400"),
 *   @OA\Property (property="errors", type="boolean", example="true"),
 *   @OA\Property (property="data", type="array|object", example="[]|{}"),
 *   example={"message": "error", "status_code": 400, "errors": true, "data": "[]|{}"}
 * )
 */
class ApiResponse {
    
    /**
     * 
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return type
     */
    public static function success($data = null, string $message = 'success', int $statusCode = 200)
    {
        $data = (!$data) ? new \stdClass : $data;
        
        return response()->json([
            'message' => $message,
            'status_code' => $statusCode,
            'errors' => false,
            'data' => $data,
        ], $statusCode);
    }
    
    /**
     * 
     * @param type $data
     * @param string $message
     * @param int $statusCode
     * @return type
     */
    public static function error($data = null, string $message = 'error', int $statusCode = 500)
    {
        $data = (!$data) ? new \stdClass : $data;
        
        return response()->json([
            'message' => $message,
            'status_code' => $statusCode,
            'errors' => true,
            'data' => $data,
        ], $statusCode);
    }
    
}
