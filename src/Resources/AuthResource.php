<?php

namespace Imunew\JWTAuth\Resources;

use Imunew\JWTAuth\ValueObjects\JwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthResource
 * @package Imunew\JWTAuth\Resources
 *
 * @property-read JwtToken $resource
 */
class AuthResource extends JsonResource
{
    /** @var string|null */
    public static $wrap = null;

    /**
     * {@inheritDoc}
     */
    public function toArray($request)
    {
        return [];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $response = parent::toResponse($request);
        $response->withCookie(cookie(
            config('jwt-auth.cookie.key'),
            $this->resource->accessToken,
            config('jwt.refresh_ttl'), // minutes
            null, // path
            '', // domain
            $request->getScheme() === 'https', // secure
            true // httpOnly
        ));
        return $response;
    }
}
