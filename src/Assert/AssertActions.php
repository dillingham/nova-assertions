<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertActions
{
    public $novaActionResponse;

    public function assertActionsInclude($class)
    {
        if (is_null($this->novaActionResponse)) {
            $this->setNovaActionResponse();
        }

        $this->novaActionResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertActionsExclude($class)
    {
        if (is_null($this->novaActionResponse)) {
            $this->setNovaActionResponse();
        }

        $this->novaActionResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaActionResponse()
    {
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
