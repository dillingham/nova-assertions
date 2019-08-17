<?php

namespace NovaTesting;

use Illuminate\Support\Str;
use NovaTesting\NovaResponse;
use Illuminate\Database\Eloquent\Model;

trait NovaAssertions
{
    public function novaIndex($resource, $filters = [])
    {
        $resource = $this->resolveUriKey($resource);
        $filters = $this->makeNovaFilters($resource, $filters);
        $endpoint = "nova-api/$resource";
        $json = $this->getJson("$endpoint?$filters");

        return new NovaResponse($json, compact('endpoint', 'resource'), $this);
    }

    public function novaDetail($resource, $resourceId)
    {
        $resource = $this->resolveUriKey($resource);
        $endpoint = "nova-api/$resource/$resourceId";
        $json = $this->getJson($endpoint);

        return new NovaResponse($json, compact('endpoint', 'resource', 'resourceId'), $this);
    }

    public function novaCreate($resource)
    {
        $resource = $this->resolveUriKey($resource);
        $endpoint = "nova-api/$resource/creation-fields";
        $json = $this->getJson($endpoint);

        return new NovaResponse($json, compact('endpoint', 'resource'), $this);
    }

    public function novaEdit($resource, $resourceId)
    {
        $resource = $this->resolveUriKey($resource);
        $endpoint = "nova-api/$resource/$resourceId/update-fields";
        $json = $this->getJson($endpoint);

        return new NovaResponse($json, compact('endpoint', 'resource', 'resourceId'), $this);
    }

    public function novaLens($resource, $lens, $filters = [])
    {
        $resource = $this->resolveUriKey($resource);
        $lens = $this->resolveUriKey($lens);
        $filters = $this->makeNovaFilters($resource, $filters);
        $endpoint = "nova-api/$resource/lens/$lens";
        $json = $this->getJson("$endpoint?$filters");

        return new NovaResponse($json, compact('endpoint', 'resource', 'lens'), $this);
    }

    public function makeNovaFilters($resource, $filters)
    {
        if (empty($filters)) {
            return '';
        }

        $encoded = base64_encode(json_encode(
            collect($filters)->map(function ($value, $key) {
                return ['class' => $key, 'value' => $value];
            })->values()
        ));

        return "filters=$encoded";
    }

    public function resolveUriKey($class)
    {
        if (strpos($class, '\\')) {
            return app($class)->uriKey();
        }

        return $class;
    }
}
