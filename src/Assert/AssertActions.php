<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertActions
{
    public $novaActionResponse;

    public function assertActionCount($amount)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonCount($amount, 'actions');

        return $this;
    }

    public function assertActionsInclude($class)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertActionsExclude($class)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaActionResponse()
    {
        if ($this->novaActionResponse) {
            return;
        }

        extract($this->novaParameters);

        $endpoint = "nova-api/$resource/actions";

        if (isset($resourceId)) {
            $endpoint = "$endpoint?resourceId=$resourceId";
        }

        $this->novaActionResponse = new NovaResponse(
            $this->parent->getJson($endpoint),
            $this->novaParameters,
            $this->parent
        );
    }
}
