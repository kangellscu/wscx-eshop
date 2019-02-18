<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    /**
     * param array|string $data
     */
    protected function json($data = [])
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }
        $data['nonceStr'] = Uuid::uuid4()->getHex();
        $data['currTimestamp'] = time();
        $data = array_merge(['code' => 0, 'message' => 'success'], $data);
        $data['sign'] = 'sha256 sign';

        return response()->json($data);
    }
}
