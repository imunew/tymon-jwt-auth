<?php

namespace Imunew\JWTAuth\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Imunew\JWTAuth\Helpers\HttpHelper;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWT;

class RefreshJwtToken extends BaseMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = null;
        try {
            $token = $this->auth->parseToken();
            $token->authenticate();
        } catch (TokenExpiredException $e) {
            // Token expired: try refresh
            try {
                return $this->refreshJwtToken($token, $request, $next);
            } catch (JWTException $e) {
                // Refresh failed (refresh expired)
            }
        } catch (JWTException $e) {
            // Invalid token
        }
        return $next($request);
    }

    /**
     * @param JWT $jwt
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|Response
     */
    private function refreshJwtToken(JWT $jwt, Request $request, Closure $next)
    {
        $newToken = $jwt->refresh();
        $request->cookies->set(config('jwt-auth.cookie.key'), $newToken);
        $response = $next($request);
        return HttpHelper::respondWithCookie($request, $response, $newToken);
    }
}
