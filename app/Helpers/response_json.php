<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;

const JSON_OPTIONS = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

function response_json($data = [],int $status = 200,array $headers = [],$option = JSON_OPTIONS):JsonResponse{
    return response()->json($data, $status,$headers, JSON_OPTIONS);
}
