<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class JsonResponse
 * Simple response object for Quiz application
 * Response format:
 * {
 *   'success': true|false,
 *   'data': [],
 *   'error': ''
 * }
 *
 */
class JsonResponse implements \JsonSerializable
{
    const STATUS_SUCCESS = true;
    const STATUS_ERROR = false;

    /**
     * Data to be returned
     * @var mixed
     */
    private $data = [];

    /**
     * Error message in case process is not success. This will be a string.
     *
     * @var string
     */
    private $error = '';
    private $message;

    /**
     * @var bool
     */
    private $success = false;

    /**
     * JsonResponse constructor.
     * @param  $data
     * @param string|null $message
     * @param string $error
     */

    public function __construct($data, string $message = null, string $error = '')
    {
        if ($this->shouldBeJson($data)) {
            $this->data = $data;
        }

        $this->message = $message;
        $this->error = $error;
        $this->success = !empty($data);
    }

    /**
     * Determine if the given content should be turned into JSON.
     *
     * @param mixed $content
     * @return bool
     */
    private function shouldBeJson($content): bool
    {
        return $content instanceof Arrayable ||
            $content instanceof Jsonable ||
            $content instanceof \ArrayObject ||
            $content instanceof \JsonSerializable ||
            is_array($content);
    }

    /**
     * Success with data
     *
     * @param array $data
     */
    public function success($data = [])
    {
        $this->success = true;
        $this->data = $data;
        $this->error = '';
    }

    /**
     * Fail with error message
     * @param string $error
     */
    public function fail($error = '')
    {
        $this->success = false;
        $this->error = $error;
        $this->data = [];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'error' => $this->error,

        ];
    }
}
