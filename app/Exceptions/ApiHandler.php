<?php

namespace App\Exceptions;

use Exception;
use Dingo\Api\Exception\Handler as DingoHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ApiHandler extends DingoHandler
{
    public function handle(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Entry for ' . str_replace('App\\', '', $exception->getModel()) . ' not found',

            ], 404);
        }
        if($exception instanceof QueryException){
            return response()->json([
                'status' => 'Cannot perform operation at the moment',
                'message' => $exception->errorInfo[2]
            ], 500);
        }
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json(['message' => 'Unauthorized', 'status_code' => 401], 401);
        }
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => 'cannot created category',
                'message' => $exception->errors()
            ]);
        }
        return parent::handle($exception);
    }
}
