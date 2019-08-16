<?php

namespace NovaTesting;

use NovaTesting\NovaResponse;

trait NovaAssertions
{
    public function novaIndex($resource, $filters = [])
    {
        $filters = empty($filters) ? '' : $this->makeNovaFilters($resource, $filters);

        $json = $this->getJson("nova-api/$resource?$filters");

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

    public function makeNovaFilters($resource, $filters)
    {
        $encoded = base64_encode(json_encode(
            collect($filters)->map(function ($value, $key) {
                return ['class' => $key, 'value' => $value];
            })->values()
        ));

        return "filters=$encoded";
    }
}
