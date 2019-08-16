<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertCards
{
    public $novaCardResponse;

    public function assertCardsInclude()
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        dd($this->novaCardResponse);

        // perform response check
    }

    public function assertCardsExclude()
    {
        if (is_null($this->novaCardResponse)) {
            $this->setNovaCardResponse();
        }

        dd($this->novaCardResponse);
        // perform response check
    }

    public function setNovaCardResponse()
    {
        extract($this->novaParameters);

        $this->novaCardResponse = new NovaResponse(
            $this->getJson("$resource/cards?resourceId=$resourceId")
        );
    }
}
