<?php

namespace NovaTesting;

use NovaTesting\Assert\Authorization;

class NovaResponse
{
    use Authorization;

    protected $originalJsonResponse;

    public function __construct($originalJsonResponse)
    {
        $this->originalJsonResponse = $originalJsonResponse;
    }

    public function __call($method, $arguments)
    {
        $this->originalJsonResponse->$method(...$arguments);
    }

    public function __get($property)
    {
        return $this->originalJsonResponse->$property;
    }
}
