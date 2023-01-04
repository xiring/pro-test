<?php


namespace App\Http\Responses;


use Illuminate\Contracts\Support\Responsable;

class SuccessResponse implements Responsable
{

    public function __construct(protected  $data = null, public  $message = null)
    {

    }

    public function toResponse($request)
    {
        $response = [
            'status' => 201,
            'message' => 'SUCCESS'
        ];
        if ($this->data) {
            $response['data'] = $this->data;
        }
        if ($this->message) {
            $response['message'] = $this->message;
        }
        if ($request->wantsJson()) {
            return response()->json($response);
        }
        return response($response);

    }
}
