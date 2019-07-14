<?php

namespace NovaTesting\Assert;

use Illuminate\Support\Arr;

trait Authorization
{
    public function assertCanDelete()
    {
        return $this->assertNovaAuthorized('Delete', true);
    }

    public function assertCannotDelete()
    {
        return $this->assertNovaAuthorized('Delete', false);
    }

    public function assertCanForceDelete()
    {
        return $this->assertNovaAuthorized('ForceDelete', true);
    }

    public function assertCannotForceDelete()
    {
        return $this->assertNovaAuthorized('ForceDelete', false);
    }

    public function assertCanRestore()
    {
        return $this->assertNovaAuthorized('Restore', true);
    }

    public function assertCannotRestore()
    {
        return $this->assertNovaAuthorized('Restore', false);
    }

    public function assertCanUpdate()
    {
        return $this->assertNovaAuthorized('Update', true);
    }

    public function assertCannotUpdate()
    {
        return $this->assertNovaAuthorized('Update', false);
    }

    public function assertCanView()
    {
        return $this->assertNovaAuthorized('View', true);
    }

    public function assertCannotView()
    {
        return $this->assertNovaAuthorized('View', false);
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
