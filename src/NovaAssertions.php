<?php

namespace NovaTesting;

use Illuminate\Support\Str;
use NovaTesting\NovaResponse;
use Illuminate\Database\Eloquent\Model;

trait NovaAssertions
{
    public function novaIndex($resource, $filters = [])
    {
        $resource = $this->resolveResourceUriKey($resource);

        $filters = empty($filters) ? '' : $this->makeNovaFilters($resource, $filters);

        $json = $this->getJson("nova-api/$resource?$filters");

        return new NovaResponse($json, compact('resource'), $this);
    }

    public function novaDetail($resource, $resourceId)
    {
        $resource = $this->resolveResourceUriKey($resource);

        $json = $this->getJson("nova-api/$resource/$resourceId");

        return new NovaResponse($json, compact('resource', 'resourceId'), $this);
    }

    public function novaCreate($resource)
    {
        $resource = $this->resolveResourceUriKey($resource);

        $json = $this->getJson("nova-api/$resource/creation-fields");

        return new NovaResponse($json, compact('resource'), $this);
    }

    public function novaEdit($resource, $resourceId)
    {
        $resource = $this->resolveResourceUriKey($resource);

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

    public function resolveResourceUriKey($resource)
    {
        if (Str::contains('/', $resource)) {
            abort_if(is_subclass_of(Model::class, $resource), 500, 'You used a Eloquent model vs a Nova resource');

            return app($resource)->uriKey();
        }

        return $resource;
    }
}
