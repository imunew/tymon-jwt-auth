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
    /**
     * @param Request $request
     * @param Response|JsonResponse $response
     * @param string $authToken
     * @return Response|JsonResponse
     */
    public function respondWithCookie(Request $request, $response, string $authToken)
    {
        return $response->withCookie(cookie(
            config('jwt-auth.cookie.key'),
            $authToken,
            config('jwt.refresh_ttl'), // minutes
            config('session.path'), // path
            self::getCookieDomain($request), // domain
            $request->getScheme() === 'https', // secure
            config('session.http_only') // httpOnly
        ));
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getCookieDomain(Request $request)
    {
        $domain = config('session.domain');
        $allowSubDomain = config('jwt-auth.cookie.allow-sub-domain');
        if (!empty($domain) && !$allowSubDomain) {
            return $domain;
        }
        $domain = $host = $request->getHost();
        $parts = explode('.', $host);
        if (count($parts) > 1) {
            $domain = '.'. implode('.', array_slice($parts, 1));
        }
        return $domain;
    }
}
