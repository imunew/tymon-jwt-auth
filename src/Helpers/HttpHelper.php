<?php

namespace Imunew\JWTAuth\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class HttpHelper
 * @package Imunew\JWTAuth\Helpers
 */
class HttpHelper
{
    /** Disabled constructor */
    private function __construct()
    {
    }

    /**
     * @param Request $request
     * @param Response|JsonResponse $response
     * @param string $authToken
     * @return Response|JsonResponse
     */
    public static function respondWithCookie(Request $request, $response, string $authToken)
    {
        return $response->withCookie(cookie(
            config('jwt-auth.cookie.key'),
            $authToken,
            config('jwt.refresh_ttl'), // minutes
            null, // path
            '', // domain
            $request->getScheme() === 'https', // secure
            true // httpOnly
        ));
    }
}
