<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use NovaTesting\NovaAssertions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaEditTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testFields()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $response = $this->novaEdit('users', $user->id);
        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password']);
        $response->assertFieldsInclude(['email' => $user->email, 'name' => $user->name]);

        $response->assertFieldsExclude('id');
        $response->assertFieldsExclude(['created_at', 'updated_at']);

        $response->assertFields(function ($fields) {
            return $fields->count() == 4;
        });
    }
}
