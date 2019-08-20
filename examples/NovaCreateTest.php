<?php

namespace Tests\Feature;

use App\User;
use App\Group;
use Tests\TestCase;
use NovaTesting\NovaAssertions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaCreateTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testFields()
    {
        $this->be(factory(User::class)->create());

        $response = $this->novaCreate('users');
        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password']);


        $response->assertFieldsExclude('id');
        $response->assertFieldsExclude(['created_at', 'updated_at']);

        $response->assertFields(function ($fields) {
            return $fields->count() == 4;
        });

        $response->assertFields(function ($fields) {
            return $fields->firstWhere('attribute', 'group');
        });
    }

    public function testRelations()
    {
        $this->be(factory(User::class)->create());

        $group = factory(Group::class)->create();

        $users = factory(User::class, 3)->create([
            'group_id' => $group->id
        ]);

        $this->novaDetail('groups', $group->id)
            ->assertRelation('users', function ($users) {
                return $users->count() == 3;
            });

        $this->novaCreate('users')
            ->assertRelation('group', function ($groups) {
                return $groups->count() == 1;
            });
    }
}
