<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertActions
{
    public $novaActionResponse;

    public function assertActionsInclude()
    {
        if (is_null($this->novaActionResponse)) {
            $this->setNovaActionResponse();
        }

        // perform response check
    }

    public function assertActionsExclude()
    {
        if (is_null($this->novaActionResponse)) {
            $this->setNovaActionResponse();
        }

        // perform response check
    }

    public function setNovaActionResponse()
    {
        extract($this->novaParameters);

        $this->novaActionResponse = new NovaResponse(
            $this->getJson("$resource/actions?resourceId=$resourceId")
        );
    }
}
