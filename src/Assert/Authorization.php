<?php

namespace NovaTesting\Assert;

trait Authorization
{
    public function assertCanDelete()
    {
        //  resource.authorizedToDelete: true
    }

    public function assertCanForceDelete()
    {
        // resource.authorizedToForceDelete: false
    }

    public function assertCanRestore()
    {
        // resource.authorizedToRestory: false
    }

    public function assertCanUpdate()
    {
        // resource.authorizedToUpdate: false
    }

    public function assertCanView()
    {
        //
    }

    public function assertCanViewAny()
    {
        //
    }
}
