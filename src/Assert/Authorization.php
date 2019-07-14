<?php

namespace NovaTesting\Assert;

use Illuminate\Support\Arr;

trait Authorization
{
    public function assertCanDelete()
    {
        $this->assertNovaAuthorized('Delete', true);
    }

    public function assertCannotDelete()
    {
        $this->assertNovaAuthorized('Delete', false);
    }

    public function assertCanForceDelete()
    {
        $this->assertNovaAuthorized('ForceDelete', true);
    }

    public function assertCannotForceDelete()
    {
        $this->assertNovaAuthorized('ForceDelete', false);
    }

    public function assertCanRestore()
    {
        $this->assertNovaAuthorized('Restore', true);
    }

    public function assertCannotRestore()
    {
        $this->assertNovaAuthorized('Restore', false);
    }

    public function assertCanUpdate()
    {
        $this->assertNovaAuthorized('Update', true);
    }

    public function assertCannotUpdate()
    {
        $this->assertNovaAuthorized('Update', false);
    }

    public function assertCanView()
    {
        $this->assertNovaAuthorized('View', true);
    }

    public function assertCannotView()
    {
        $this->assertNovaAuthorized('View', false);
    }

    public function assertNovaAuthorized($action, $boolean = true)
    {
        $action = 'authorizedTo' . ucwords($action);

        if (isset($this->original['resource'])) {
            return $this->assertJson([
                'resource' => [ $action => $boolean ]
            ]);
        }

        if (isset($this->original['resources']) && count($this->original['resources'])) {
            return $this->assertJson([
                'resources' => [
                    0 => [ $action => $boolean ]
                ]
            ]);
        }

        abort(500, 'No results');
    }
}
