<?php

namespace Imunew\JWTAuth\ValueObjects;

/**
 * Class JwtToken
 * @package Imunew\JWTAuth\ValueObject
 *
 * @property-read string $accessToken
 * @property-read int|null $expiresIn
 */
class JwtToken
{
    use ReadProperties;

    public function __construct(string $accessToken, ?int $expiresIn = null)
    {
        $this->properties['accessToken'] = $accessToken;
        $this->properties['expiresIn'] = $expiresIn;
    }
}
