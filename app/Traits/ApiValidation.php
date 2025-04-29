<?php

namespace App\Traits;

Trait ApiValidation
{
    public $validationErrorStatus = 422;
    public $uncompletedErrorStatus = 423;
    public $unauthorizedErrorStatus = 403;
    public $notFoundErrorStatus = 404;
    public $invalidErrorStatus = 400;
    public $notAcceptableStatus = 406;
    public $unknownStatus = 419;

    public function validationErrors($error)
    {
        return ['message' => 'The given data was invalid.', 'error' => $error];
    }

    public function withErrors($error)
    {
        return ['status' => 'failed', 'message' => $error];
    }

    public function withSuccess($msg)
    {
        return ['status' => 'success', 'message' => $msg];
    }

    public function jsonError($error, $code = 200)
    {
        return response()->json([
            'status' => 'error',
            'message' => $error,
        ],200);
    }
    public function jsonSuccess($data, $message = null, $statusCode = 200)
    {
        if ($message){
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => $message,
            ],$statusCode);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ],200);
    }
}
