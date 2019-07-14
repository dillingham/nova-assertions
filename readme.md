# Nova Assertions

Work in progress. Not functional yet.

### Installation

```
composer require dillingham/nova-assertions
```
```php
use NovaTesting\NovaRequests;

class UserTest extends TestCase
{
    use NovaRequests;

    public function testNova()
    {
        $this->be(factory(User::class)->create());

        $this->novaIndex('users');
            ->assertFieldExists('email');
            ->assertCanUpdate()
            ->assertCannotDelete();
    }
}
```

### Authentication
Log in a user that **[has access to Nova](https://nova.laravel.com/docs/2.0/installation.html#authorizing-nova)**
```php
$this->be(factory(User::class)->create());
```

### Requests

Request Nova's results with one of the following:

| Method | Description |
| - | - |
| ->novaIndex($resource) | todo |
| ->novaDetail($resource, $id) | todo |
| ->novaCreate($resource) | todo |
| ->novaEdit($resource, $id) | todo |

TODO

->novaRelation('workflows')

->novaRelation('workflows', $id, 'users')

### Assert Fields

Assert the columns or form fields with the following:

| Method | Description |
| - | - |
| ->assertFieldExists() | todo |
| ->assertFieldMissing() | todo |
| ->assertFieldEquals() | todo |
| ->assertFieldDoesntEquals() | todo |

### Assert Authorization

The following assert against the auth user & Nova's use of policies

| Method | Description |
| - | - |
| ->assertCanDelete() | assert user can delete |
| ->assertCannotDelete() | assert user can not delete |
| ->assertCanForceDelete() | assert user can force delete |
| ->assertCannotForceDelete() | assert user can not force delete |
| ->assertCanRestore() | assert user can restore |
| ->assertCannotRestore() | assert user can not restore |
| ->assertCanUpdate() | assert user can update |
| ->assertCannotUpdate() | assert user can not update |
| ->assertCanView() | assert user can view |
| ->assertCannotView() | assert user can not view |

You can call other **[http response methods](https://laravel.com/docs/5.8/http-tests#available-assertions)** too:

```php
$this->novaIndex('users')
    ->assertOk();
    ->assertUnauthorized();
    ->assertJson([]);
```