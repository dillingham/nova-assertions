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

        return $this->assertJsonFragment([
            $action => $boolean
        ]);
    }
}
