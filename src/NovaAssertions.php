<?php

namespace NovaTesting;

use Illuminate\Support\Str;
use NovaTesting\NovaResponse;
use Illuminate\Database\Eloquent\Model;

trait NovaAssertions
{
    public function novaIndex($resource, $filters = [], $search = [])
    {
        $resource = $this->resolveUriKey($resource);
        $endpoint = "nova-api/$resource";

        if (!empty($filters) && !empty($search)) {
            $filterQuery = $this->makeNovaFilters($resource, $filters);
            $searchQuery = http_build_query($search);
            $queryString = "$filterQuery&$searchQuery";
        } elseif (!empty($filters)) {
            $queryString = $this->makeNovaFilters($resource, $filters);
        } elseif (!empty($search)) {
            $queryString = http_build_query($search);
        } else {
            $queryString = '';
        }

        $json = $this->getJson("$endpoint?$queryString");

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

    public function novaStore($resource, $data){
        $resource = $this->resolveUriKey($resource);
        $endpoint = "/nova-api/$resource?editMode=create&editing=true";
        $response = $this->post($endpoint, $data);

        return new NovaResponse($response, compact('endpoint', 'resource'), $this);
    }

    public function novaUpdate($resource, $data, $resourceId){
        $resource = $this->resolveUriKey($resource);
        $endpoint = "/nova-api/$resource/$resourceId?editMode=update&editing=true";
        $response = $this->put($endpoint, $data);

        return new NovaResponse($response, compact('endpoint', 'resource'), $this);
    }

    public function makeNovaFilters($resource, $filters)
    {
        if (empty($filters)) {
            return '';
        }

        $encoded = base64_encode(json_encode(
            collect($filters)->map(function ($value, $key) {
                return [$key => $value];
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
