<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertCards
{
    public $novaCardResponse;

    public function assertCardCount($amount)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonCount($amount);

        return $this;
    }

    public function assertCardsInclude($class)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertCardsExclude($class)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaCardResponse()
    {
        if ($this->novaCardResponse) {
            return;
        }

        extract($this->novaParameters);

        $endpoint = "$endpoint/cards";

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
