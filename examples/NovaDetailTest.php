<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use NovaTesting\NovaAssertions;
use App\Nova\Actions\ApproveUser;
use App\Nova\Actions\ProcessOrder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaDetailTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testActions()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaDetail('users', $authed->id);

        $response->assertActionCount(1);
        $response->assertActionsInclude(ApproveUser::class);
        $response->assertActionsExclude(ProcessOrder::class);
        $response->assertActions(function ($actions) {
            return $actions->count() == 1;
        });
    }

    public function testFields()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();

        $this->be($authed);

        $response = $this->novaDetail('users', $authed->id);

        $response->assertFieldsInclude('id');
        $response->assertFieldsInclude(['id', 'email', 'name']);
        $response->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email]);

        $response->assertFieldsExclude('created_at');
        $response->assertFieldsExclude(['created_at', 'updated_at']);
        $response->assertFieldsExclude(['created_at' => $authed->created_at, 'updated_at' => $authed->updated_at]);

        $response->assertFields(function ($fields) {
            return $fields->count() == 6;
        });
    }
}
