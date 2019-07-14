<?php

namespace NovaTesting;

use NovaTesting\NovaResponse;

trait NovaAssertions
{
    public function novaIndex($resource)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource")
        );
    }

    public function novaDetail($resource, $id)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource/$id")
        );
    }

    public function novaCreate($resource)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource/creation-fields")
        );
    }

    public function novaEdit($resource, $id)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource/$id/update-fields")
        );
    }
}
