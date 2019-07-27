<?php

namespace App\Exceptions;

use Exception;
use Dingo\Api\Exception\Handler as DingoHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiHandler extends DingoHandler
{
    public function handle(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
        return response()->json([
            'status' => 'error',
            'message'=>'Entry for '.str_replace('App\\', '', $exception->getModel()).' not found',
        
        ], 404);
    }
        
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json(['message' => 'Unauthorized', 'status_code' => 401], 401);
        }
        return parent::handle($exception);
    }
}