<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function sendResponse($response, $status, $code)
    {
        return response()->json(['data' => $response, 'status' => $status, $code]);
    }
}
