<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Response;

class Admin extends BaseMiddleware
{
    use Helpers;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return  $this->response->errorBadRequest();
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->response->error('Expired Token',Response::HTTP_UNAUTHORIZED);
            // return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->response->error('Invalid Token',Response::HTTP_UNAUTHORIZED);
            // return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (!$user) {
            return $this->response->errorNotFound();
        }

        if (!$user->is_admin) {
            return $this->response->errorUnauthorized();
           
        }



        return $next($request);
    }
    
}