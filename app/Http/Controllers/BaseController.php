<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * Send an error response.
     *
     * @param string $error The main error message.
     * @param array $errorMessages Additional error details (e.g., validation errors).
     * @param int $code HTTP status code (default: 400).
     * @return JsonResponse
     */
    public function sendError(string $error, array $errorMessages, int $code = 400): JsonResponse
    {

        $response = [
            'error' => true, // Indicates that the request failed
            'message' => $error, // Main error message
        ];

        // Include additional error messages if provided
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages; // Attach detailed errors (e.g., validation issues)
        }

        return response()->json($response, $code); // Return JSON response with HTTP status code
    }

    /**
     * Send a success response.
     *
     * @param mixed $result The data payload (e.g., user details, success message).
     * @param string $message Success message.
     * @param int $code HTTP status code (default: 200).
     * @return JsonResponse
     */
    public function sendResponse(mixed $result, string $message, int $code = 200): JsonResponse
    {

        $response = [
            'error' => 'ok', // Indicates that the request was successful
            'data' => $result, // The actual response data
            'message' => $message, // Success message
        ];

        return response()->json($response, $code); // Return JSON response with HTTP status code
    }
}
