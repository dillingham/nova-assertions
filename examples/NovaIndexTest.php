<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Nova\Lenses\UserLens;
use App\Nova\Lenses\OrderLens;
use NovaTesting\NovaAssertions;
use App\Nova\Filters\UserFilter;
use App\Nova\Filters\UserStatus;
use App\Nova\Actions\ApproveUser;
use App\Nova\Filters\OrderStatus;
use App\Nova\Metrics\UsersPerDay;
use App\Nova\Actions\ProcessOrder;
use App\Nova\Metrics\OrdersPerDay;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NovaIndexTest extends TestCase
{
    use NovaAssertions, RefreshDatabase;

    public function testCards()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertCardCount(1);
        $response->assertCardsInclude(UsersPerDay::class);
        $response->assertCardsExclude(OrdersPerDay::class);
        $response->assertCards(function ($cards) {
            return $cards->count() == 1;
        });
    }

    public function testActions()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertActionCount(1);
        $response->assertActionsInclude(ApproveUser::class);
        $response->assertActionsExclude(ProcessOrder::class);
        $response->assertActions(function ($actions) {
            return $actions->count() == 1;
        });
    }

    public function testFilters()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertFilterCount(2);
        $response->assertFiltersInclude(UserStatus::class);
        $response->assertFiltersExclude(OrderStatus::class);
        $response->assertFilters(function ($filters) {
            return $filters->count() == 2;
        });
    }

    public function testFilteredIndex()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();

        $this->be($authed);

        $response = $this->novaIndex('users', [
            UserFilter::class => $authed->id
        ]);

        $response->assertResourceCount(1);
        $response->assertFieldsInclude(['id' => $authed->id]);
    }

    public function testLenses()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertLensCount(1);
        $response->assertLensesInclude(UserLens::class);
        $response->assertLensesExclude(OrderLens::class);
        $response->assertLenses(function ($lenses) {
            return $lenses->count() == 1;
        });
    }

    public function testResources()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();
        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertResourceCount(10);
        $response->assertResources(function ($resources) {
            return $resources->count() == 10;
        });
    }

    public function testFields()
    {
        $users = factory(User::class, 10)->create();
        $authed = $users->first();

        $this->be($authed);

        $response = $this->novaIndex('users');

        $response->assertFieldsInclude('id');
        $response->assertFieldsInclude(['id', 'email', 'name']);
        $response->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email]);
        $response->assertFieldsInclude('id', $users->pluck('id'));

        $response->assertFieldsExclude('created_at');
        $response->assertFieldsExclude(['created_at', 'updated_at']);
        $response->assertFieldsExclude(['created_at' => $authed->created_at, 'updated_at' => $authed->updated_at]);
        $response->assertFieldsExclude('created_at', $users->pluck('created_at'));

        $response->assertFields(function ($fields) {
            // collection of field arrays
            return $fields->count() == 10 && count($fields->first()) == 6;
        });
    }
}
