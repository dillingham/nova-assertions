<?php

namespace NovaTesting\Assert;

use closure;
use NovaTesting\NovaResponse;

trait AssertFilters
{
    public $novaFilterResponse;

    public function assertFilterCount($amount)
    {
        $this->setNovaFilterResponse();

        $this->novaFilterResponse->assertJsonCount($amount);

        return $this;
    }

    public function assertFilters(closure $callable)
    {
        $original = $this->novaFilterResponse->original;

        $filters = collect(json_decode(json_encode($original, true)));

        PHPUnit::assertTrue($callable($filters));
    }

    public function assertFiltersInclude($class)
    {
        $this->setNovaFilterResponse();

        $this->novaFilterResponse->assertJsonFragment([
            'class' => $class
        ]);

        return $this;
    }

    public function assertFiltersExclude($class)
    {
        $this->setNovaFilterResponse();

        $this->novaFilterResponse->assertJsonMissing([
            'class' => $class
        ]);

        return $this;
    }

    public function setNovaFilterResponse()
    {
        if ($this->novaFilterResponse) {
            return;
        }

        extract($this->novaParameters);

        $this->novaFilterResponse = new NovaResponse(
            $this->parent->getJson("$endpoint/filters"),
            $this->novaParameters,
            $this->parent
        );
    }
}
