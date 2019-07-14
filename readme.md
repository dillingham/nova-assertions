# Nova Assertions

Work in progress. Not functional yet.

### Installation

```
composer require dillingham/nova-assertions
```
```php
use NovaTesting\NovaAssertions;

class UserTest extends TestCase
{
    use NovaAssertions;

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

# Assert Http
You can call other **[http response methods](https://laravel.com/docs/5.8/http-tests#available-assertions)** also:

```php
$this->novaIndex('users')
    ->assertOk();
    ->assertUnauthorized();
    ->assertStatus(200);
    ->assertSessionHas()
    ->assertJson([
        //
    ]);
```

# Assert Fields

Assert columns or form fields with the following:

#### assertFieldExists
todo
```php
$response->assertFieldExists();
```
#### assertFieldMissing
todo
```php
$response->assertFieldMissing();
```
#### assertFieldEquals
todo
```php
$response->assertFieldEquals();
```
#### assertFieldDoesntEquals
todo
```php
$response->assertFieldDoesntEquals();
```

# Assert Authorization

The following assert against the auth user & **[Nova's use of policies](https://nova.laravel.com/docs/2.0/resources/authorization.html#authorization)**

#### assertCanDelete
Assert that the authenticated user can delete
```php
$response->assertCanDelete();
```
#### assertCannotDelete
Assert that the authenticated user can not delete
```php
$response->assertCannotDelete();
```
#### assertCanForceDelete
Assert that the authenticated user can force delete
```php
$response->assertCanForceDelete();
```
#### assertCannotForceDelete
Assert that the authenticated user can not force delete
```php
$response->assertCannotForceDelete();
```
#### assertCanRestore
Assert that the authenticated user can restore
```php
$response->assertCanRestore();
```
#### assertCannotRestore
Assert that the authenticated user can not restore
```php
$response->assertCannotRestore();
```
#### assertCanUpdate
Assert that the authenticated user can update
```php
$response->assertCanUpdate();
```
#### assertCannotUpdate
Assert that the authenticated user can not update
```php
$response->assertCannotUpdate();
```
#### assertCanView
Assert that the authenticated user can view
```php
$response->assertCanView();
```
#### assertCannotView
Assert that the authenticated user can not view
```php
$response->assertCannotView();
```