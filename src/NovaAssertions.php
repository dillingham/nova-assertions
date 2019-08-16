<?php

namespace NovaTesting;

use NovaTesting\NovaResponse;

trait NovaAssertions
{
    public function novaIndex($resource)
    {
        $this->novaParameters = compact('resource');

        return new NovaResponse(
            $this->getJson("nova-api/$resource")
        );
    }

    public function novaDetail($resource, $resourceId)
    {
        $this->novaParameters = compact('resource', 'resourceId');

        return new NovaResponse(
            $this->getJson("nova-api/$resource/$resourceId")
        );
    }

    public function novaCreate($resource)
    {
        $this->novaParameters = compact('resource');

        return new NovaResponse(
            $this->getJson("nova-api/$resource/creation-fields")
        );
    }

    public function novaEdit($resource, $resourceId)
    {
        $this->novaParameters = compact('resource', 'resourceId');

        return new NovaResponse(
            $this->getJson("nova-api/$resource/$resourceId/update-fields")
        );
    }
}
