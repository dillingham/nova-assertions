<?php

namespace NovaTesting;

use Illuminate\Database\Eloquent\Model;
use NovaTesting\Assert\AssertActions;
use NovaTesting\Assert\AssertCards;
use NovaTesting\Assert\AssertFields;
use NovaTesting\Assert\AssertFilters;
use NovaTesting\Assert\AssertLenses;
use NovaTesting\Assert\AssertPolicies;
use NovaTesting\Assert\AssertRelations;
use NovaTesting\Assert\AssertResources;

/**
 * @mixin \Illuminate\Foundation\Testing\TestResponse
 */
class NovaResponse
{
    use AssertResources,
        AssertRelations,
        AssertPolicies,
        AssertFilters,
        AssertActions,
        AssertLenses,
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

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function originalResponse()
    {
        return $this->originalJsonResponse;
    }
}
