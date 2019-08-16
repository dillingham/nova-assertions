<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertFilters
{
    public $novaFilterResponse;

    public function assertFiltersInclude($class)
    {
        if (is_null($this->novaFilterResponse)) {
            $this->setNovaFilterResponse();
        }

        $this->novaFilterResponse->assertJsonFragment([
            'class' => $class
        ]);

        return $this;
    }

    public function assertFiltersExclude($class)
    {
        if (is_null($this->novaFilterResponse)) {
            $this->setNovaFilterResponse();
        }

        $this->novaFilterResponse->assertJsonMissing([
            'class' => $class
        ]);

        return $this;
    }

    public function setNovaFilterResponse()
    {
        extract($this->novaParameters);

        $this->novaFilterResponse = new NovaResponse(
            $this->parent->getJson("nova-api/$resource/filters"),
            $this->novaParameters,
            $this->parent
        );
    }
}
