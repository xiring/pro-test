<?php

namespace App\Tools;

class Response
{

    /**
     * @param $message
     * @param $data
     * @param int $status
     * @param array $error
     * @return array
     */
    public static function response($message, $data, int $status = 200, array $error=[], $meta = [])
    {
        return [
            'message' => $message,
            'data' => $data,
            'status' => $status,
            'errors' => $error,
            'meta' => $meta,
        ];
    }
}
