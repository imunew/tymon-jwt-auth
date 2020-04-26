<?php

namespace Tests\ValueObjects;

use Imunew\JWTAuth\ValueObjects\JwtToken;
use Tests\TestCase;

class JwtTokenTest extends TestCase
{
    /**
     * @test
     */
    public function missing_property()
    {
        $token = new JwtToken('test-access-token');
        $this->assertFalse(isset($token->missingValue));
        $this->assertNull($token->missingValue);
    }
}
