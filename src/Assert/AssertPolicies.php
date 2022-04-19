<?php

namespace NovaTesting\Assert;

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert as PHPUnit;
use Laravel\Nova\Nova;

trait AssertPolicies
{
    public function assertCanView()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToView);
    }

    public function assertCannotView()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToView);
    }

    public function assertCanCreate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToCreate);
    }

    public function assertCannotCreate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToCreate);
    }

    public function assertCanDelete()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToDelete);
    }

    public function assertCannotDelete()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToDelete);
    }

    public function assertCanForceDelete()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToForceDelete);
    }

    public function assertCannotForceDelete()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToForceDelete);
    }

    public function assertCanRestore()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToRestore);
    }

    public function assertCannotRestore()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToRestore);
    }

    public function assertCanUpdate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToUpdate);
    }

    public function assertCannotUpdate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToUpdate);
    }

    public function assertCanReplicate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToReplicate);
    }

    public function assertCannotReplicate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToReplicate);
    }

    public function assertCanImpersonate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertTrue($model->authorizedToImpersonate);
    }

    public function assertCannotImpersonate()
    {
        $model = $this->resolveNovaModel();

        PHPUnit::assertFalse($model->authorizedToImpersonate);
    }

    private function resolveNovaModel()
    {
        return reset($this->originalResponse()->baseResponse->getData()->resources);
    }
}
