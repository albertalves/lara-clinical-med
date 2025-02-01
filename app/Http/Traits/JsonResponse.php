<?php

namespace App\Http\Traits;

trait JsonResponse
{
    /**
     * @param $msg
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($msg, $data = [], $status = 200)
    {
        return response()->json(
            [
                'msg' => $msg,
                'status' => in_array($status, [200,201,204]) ? 'ok' : 'error',
                'data' => $data,
            ],
            $status
        );
    }
}
