<?php

namespace NovaTesting;

use NovaTesting\Assert\AssertCards;
use NovaTesting\Assert\AssertFields;
use NovaTesting\Assert\AssertActions;
use NovaTesting\Assert\AssertFilters;
use NovaTesting\Assert\AssertPolicies;
use NovaTesting\Assert\AssertResources;

class NovaResponse
{
    use AssertResources,
        AssertPolicies,
        AssertFilters,
        AssertActions,
        AssertFields,
        AssertCards;

    protected $originalJsonResponse;

    protected $novaParameters;

    protected $parent;

    public function __construct($originalJsonResponse, $parameters, $parent)
    {
        $this->originalJsonResponse = $originalJsonResponse;

        $this->novaParameters = $parameters;

        $this->parent = $parent;
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
