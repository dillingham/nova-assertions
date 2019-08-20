<?php

namespace NovaTesting\Assert;

use closure;
use NovaTesting\NovaResponse;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

trait AssertRelations
{
    public $novaRelationshipResponse = [];

    public function assertRelation($key, closure $callable)
    {
        $this->setNovaRelationshipResponse($key);

        $original = $this->novaRelationshipResponse[$key]->original;

        $results = collect(json_decode(json_encode($original['resources'], true)));

        PHPUnit::assertTrue($callable($results));

        return $this;
    }

    public function setNovaRelationshipResponse($key)
    {
        if (isset($this->novaRelationshipResponse[$key])) {
            return;
        }

        extract($this->novaParameters);

        $original = $this->originalResponse()->original;

        if (isset($original['resource']['fields'])) {
            $path = 'resource.fields';
        }

        if (isset($original['fields'])) {
            $path = 'fields';
        }

        $field = collect(data_get($original, $path))->firstWhere('attribute', $key);

        abort_if(is_null($field), 500, 'Field not found');

        if ($field instanceof HasMany) {
            $endpoint = "nova-api/$key?viaResource=$resource&viaResourceId=$resourceId&viaRelationship=$key";
        }

        if ($field instanceof BelongsTo) {
            $endpoint = "nova-api/$resource/associatable/$key";

            if (isset($resourceId)) {
                $endpoint = "$endpoint?viaResourceId=$resourceId";
            }
        }

        $this->novaRelationshipResponse[$key] = new NovaResponse(
            $this->parent->getJson($endpoint),
            $this->novaParameters,
            $this->parent
        );
    }
}
