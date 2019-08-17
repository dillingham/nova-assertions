<?php

namespace NovaTesting\Assert;

use Illuminate\Support\Arr;
use NovaTesting\NovaResponse;

trait AssertResources
{
    public function assertResourceCount($amount)
    {
        $this->assertJsonCount($amount, 'resources');

        return $this;
    }

    public function assertResources(closure $callable)
    {
        $original = $this->novaFilterResponse->original;

        $resources = collect(json_decode(json_encode(Arr::get($original, 'resources', []), true)));

        PHPUnit::assertTrue($callable($resources));
    }
}
