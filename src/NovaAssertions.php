<?php

namespace NovaTesting;

use NovaTesting\NovaResponse;

trait NovaAssertions
{
    public function novaIndex($resource)
    {
        $json = $this->getJson("nova-api/$resource");

        return new NovaResponse($json, compact('resource'), $this);
    }

    public function novaDetail($resource, $resourceId)
    {
        $json = $this->getJson("nova-api/$resource/$resourceId");

        return new NovaResponse($json, compact('resource', 'resourceId'), $this);
    }

    public function novaCreate($resource)
    {
        $json = $this->getJson("nova-api/$resource/creation-fields");

        return new NovaResponse($json, compact('resource'), $this);
    }

    public function novaEdit($resource, $resourceId)
    {
        $json = $this->getJson("nova-api/$resource/$resourceId/update-fields");

        return new NovaResponse($json, compact('resource', 'resourceId'), $this);
    }
}
