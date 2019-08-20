<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Nova\Lenses\UserLens;
use NovaTesting\NovaAssertions;
use App\Nova\Filters\UserFilter;
use App\Nova\Actions\ApproveUser;
use App\Nova\Metrics\UsersPerDay;
use App\Nova\Actions\ProcessOrder;
use App\Nova\Metrics\OrdersPerDay;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaLensTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testCards()
    {
        $this->be(factory(User::class)->create());

        $response = $this->novaLens('users', UserLens::class);

        $response->assertCardCount(1);
        $response->assertCardsInclude(UsersPerDay::class);
        $response->assertCardsExclude(OrdersPerDay::class);
        $response->assertCards(function ($cards) {
            return $cards->count() == 1;
        });
    }

    public function testActions()
    {
        $this->be(factory(User::class)->create());

        $response = $this->novaLens('users', UserLens::class);

        $response->assertActionCount(1);
        $response->assertActionsInclude(ApproveUser::class);
        $response->assertActionsExclude(ProcessOrder::class);
        $response->assertActions(function ($actions) {
            return $actions->count() == 1;
        });
    }

    public function testFilteredLens()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();

        $this->be($authed);

        $response = $this->novaLens('users', UserLens::class, [
            UserFilter::class => $authed->id
        ]);

        $response->assertResourceCount(1);
        $response->assertFieldsInclude(['id' => $authed->id]);
    }

    public function testFields()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();

        $this->be($authed);

        $response = $this->novaLens('users', UserLens::class);

        $response->assertFieldsInclude('id');
        $response->assertFieldsInclude(['id', 'email', 'name']);
        $response->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email]);
        $response->assertFieldsExclude('created_at');
        $response->assertFieldsExclude(['created_at', 'updated_at']);
        $response->assertFieldsExclude(['created_at' => $authed->created_at, 'updated_at' => $authed->updated_at]);
        $response->assertFields(function ($fields) {
            // collection of field arrays
            return $fields->count() == 10 && count($fields->first()) == 3;
        });
    }
}
