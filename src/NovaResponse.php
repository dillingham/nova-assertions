<?php

namespace NovaTesting;

use NovaTesting\Assert\AssertCards;
use NovaTesting\Assert\AssertFields;
use NovaTesting\Assert\AssertActions;
use NovaTesting\Assert\AssertPolicies;

class NovaResponse
{
    use AssertPolicies,
        AssertActions,
        AssertFields,
        AssertCards;

    protected $originalJsonResponse;

    protected $novaParameters;

    public function __construct($originalJsonResponse, $parameters)
    {
        $this->originalJsonResponse = $originalJsonResponse;

        $this->novaParameters = $parameters;
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
