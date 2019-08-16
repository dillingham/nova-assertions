<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertCards
{
    public $novaCardResponse;

    public function assertCardsInclude($uriKey)
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        $this->novaCardResponse->assertJsonFragment([
            'uriKey' => $uriKey
        ]);

        return $this;
    }

    public function assertCardsExclude()
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        $this->novaCardResponse->assertJsonMissing([
            'uriKey' => $uriKey
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
