<?php

namespace Imunew\JWTAuth\ValueObjects;

/**
 * Trait ReadProperties
 * @package Imunew\JWTAuth\ValueObjects
 */
trait ReadProperties
{
    /** @var array */
    private $properties;

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!isset($this->properties[$name])) {
            return null;
        }
        return $this->properties[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->properties);
    }
}
