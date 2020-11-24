<?php

namespace NovaTesting\Assert;

use Laravel\Nova\Nova;
use Illuminate\Support\Arr;
use Illuminate\Testing\Assert as PHPUnit;

trait AssertPolicies
{
    public function assertCanCreate()
    {
        PHPUnit::assertTrue(
            collect(Nova::jsonVariables(request())['resources'])
                ->where('uriKey', $this->novaParameters['resource'])
                ->first()['authorizedToCreate']
        );
    }

    public function assertCannotCreate()
    {
        PHPUnit::assertFalse(
            collect(Nova::jsonVariables(request())['resources'])
                ->where('uriKey', $this->novaParameters['resource'])
                ->first()['authorizedToCreate']
        );
    }

    public function assertCanDelete()
    {
        return $this->assertJsonFragment([
            'authorizedToDelete' => true
        ]);
    }

    public function assertCannotDelete()
    {
        return $this->assertJsonFragment([
            'authorizedToDelete' => false
        ]);
    }

    public function assertCanForceDelete()
    {
        return $this->assertJsonFragment([
            'authorizedToForceDelete' => true
        ]);
    }

    public function assertCannotForceDelete()
    {
        return $this->assertJsonFragment([
            'authorizedToForceDelete' => false
        ]);
    }

    public function assertCanRestore()
    {
        return $this->assertJsonFragment([
            'authorizedToRestore' => true
        ]);
    }

    public function assertCannotRestore()
    {
        return $this->assertJsonFragment([
            'authorizedToRestore' => false
        ]);
    }

    public function assertCanUpdate()
    {
        return $this->assertJsonFragment([
            'authorizedToUpdate' => true
        ]);
    }

    public function assertCannotUpdate()
    {
        return $this->assertJsonFragment([
            'authorizedToUpdate' => false
        ]);
    }

    public function assertCanView()
    {
        return $this->assertJsonFragment([
            'authorizedToView' => true
        ]);
    }

    public function assertCannotView()
    {
        return $this->assertJsonFragment([
            'authorizedToView' => false
        ]);
    }
}
