<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Nova\Lenses\OrderLens;
use NovaTesting\NovaAssertions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaPolicyTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testPolicyCan()
    {
        $this->be(factory(User::class)->create());

        $response = $this->novaIndex('users');

        $response->assertOk();
        $response->assertCanView();
        $response->assertCanCreate();
        $response->assertCanUpdate();
        $response->assertCanDelete();
        $response->assertCanForceDelete();
        $response->assertCanRestore();
    }

    public function testPolicyCannotViewAny()
    {
        Config::set('testing.viewAny', false);
        $this->be(factory(User::class)->create());
        $response = $this->novaIndex('users');
        $response->assertStatus(403);
    }

    public function testPolicyCannot()
    {
        $this->be(factory(User::class)->create());

        Config::set('testing.create', false);
        Config::set('testing.update', false);
        Config::set('testing.delete', false);
        Config::set('testing.forceDelete', false);
        Config::set('testing.restore', false);

        $response = $this->novaIndex('users');

        $response->assertCannotCreate();
        $response->assertCannotUpdate();
        $response->assertCannotDelete();
        $response->assertCannotForceDelete();
        $response->assertCannotRestore();
    }
}
