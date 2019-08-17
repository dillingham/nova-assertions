<?php

namespace NovaTesting\Assert;

use closure;
use Illuminate\Support\Arr;
use NovaTesting\NovaResponse;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

trait AssertResources
{
    public function assertResourceCount($amount)
    {
        $this->assertJsonCount($amount, 'resources');

        return $this;
    }

    public function assertResources(closure $callable)
    {
        $resources = collect(json_decode(json_encode(Arr::get($this->original, 'resources', []), true)));

        PHPUnit::assertTrue($callable($resources));

        return $this;
    }
}
