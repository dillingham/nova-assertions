<?php

namespace NovaTesting\Assert;

use closure;
use Illuminate\Support\Arr;
use NovaTesting\NovaResponse;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

trait AssertActions
{
    public $novaActionResponse;

    public function assertActionCount($amount)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonCount($amount, 'actions');

        return $this;
    }

    public function assertActions(closure $callable)
    {
        $original = $this->novaActionResponse->original;

        $actions = collect(json_decode(json_encode(Arr::get($original, 'actions', []), true)));

        PHPUnit::assertTrue($callable($actions));

        return $this;
    }

    public function assertActionsInclude($class)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertActionsExclude($class)
    {
        $this->setNovaActionResponse();

        $this->novaActionResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaActionResponse()
    {
        if ($this->novaActionResponse) {
            return;
        }

        extract($this->novaParameters);

        $endpoint = "$endpoint/actions";

        if (isset($resourceId)) {
            $endpoint = "$endpoint?resourceId=$resourceId";
            $endpoint = str_replace("/$resourceId", '', $endpoint);
        }

        abort_if(strpos($endpoint, 'creation-fields'), 500, 'No actions on forms');
        abort_if(strpos($endpoint, 'update-fields'), 500, 'No actions on forms');

        $this->novaActionResponse = new NovaResponse(
            $this->parent->getJson($endpoint),
            $this->novaParameters,
            $this->parent
        );
    }
}
