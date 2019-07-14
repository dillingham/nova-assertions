<?php

namespace NovaTesting;

use NovaTesting\Assert\Cards;
use NovaTesting\Assert\Fields;
use NovaTesting\Assert\Actions;
use NovaTesting\Assert\Authorization;

class NovaResponse
{
    use Authorization, Fields, Cards, Actions;

    protected $originalJsonResponse;

    public function __construct($originalJsonResponse)
    {
        $this->originalJsonResponse = $originalJsonResponse;
    }

    public function __get($property)
    {
        return $this->originalJsonResponse->$property;
    }

    public function __call($method, $arguments)
    {
        $this->originalJsonResponse->$method(...$arguments);

        return $this;
    }

    public function originalResponse()
    {
        return $this->originalJsonResponse;
    }
}
