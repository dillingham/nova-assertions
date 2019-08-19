<?php

namespace NovaTesting\Assert;

use closure;
use NovaTesting\NovaResponse;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

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

        return $this;
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

        abort_if(strpos($endpoint, 'creation-fields'), 500, 'No filters on forms');
        abort_if(strpos($endpoint, 'update-fields'), 500, 'No filters on forms');

        $this->novaFilterResponse = new NovaResponse(
            $this->parent->getJson("$endpoint/filters"),
            $this->novaParameters,
            $this->parent
        );
    }
}
