<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertCards
{
    public $novaCardResponse;

    public function assertCardsInclude($class)
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        $this->novaCardResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertCardsExclude($class)
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        $this->novaCardResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaCardResponse()
    {
        extract($this->novaParameters);

        $endpoint = "nova-api/$resource/cards";

        if (isset($resourceId)) {
            $endpoint = "$endpoint?resourceId=$resourceId";
        }

        $this->novaCardResponse = new NovaResponse(
            $this->parent->getJson($endpoint),
            $this->novaParameters,
            $this->parent
        );
    }
}
