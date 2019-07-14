<?php

namespace NovaTesting;

use NovaTesting\Assert\Fields;
use NovaTesting\Assert\Authorization;

class NovaResponse
{
    use Authorization, Fields;

    protected $originalJsonResponse;

    public function __construct($originalJsonResponse)
    {
        $this->originalJsonResponse = $originalJsonResponse;
    }

    public function __call($method, $arguments)
    {
        $this->originalJsonResponse->$method(...$arguments);

        return $this;
    }

    public function __get($property)
    {
        return $this->originalJsonResponse->$property;
    }
}
