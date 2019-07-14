# Nova Assertions

Perform Nova requests & assert fields & authorization

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

### Assert Http
You can call **[http response methods](https://laravel.com/docs/5.8/http-tests#available-assertions)** as usual:

```php
$response->assertOk();
```

### Assert Fields

Assert columns or form fields with the following:

```php
$response->assertFieldsInclude('id');
$response->assertFieldsInclude('id', $user->id);
$response->assertFieldsInclude(['id', 'email']);
$response->assertFieldsInclude(['id' => 1, 'email' => 'example']);
$response->assertFieldsInclude($users->pluck('id));
```
```php
$response->assertFieldsExclude('id');
$response->assertFieldsExclude('id', $user->id);
$response->assertFieldsExclude(['id', 'email']);
$response->assertFieldsExclude(['id' => 1, 'email' => 'example']);
$response->assertFieldsExclude($users->pluck('id));
```

### Assert Actions

Coming soon

### Assert  Cards

Coming soon

### Assert Authorization

The following assert against the auth user & **[Nova's use of policies](https://nova.laravel.com/docs/2.0/resources/authorization.html#authorization)**

```php
$response->assertCanView();
$response->assertCanUpdate();
$response->assertCanDelete();
$response->assertCanForceDelete();
$response->assertCanRestore();
```
```php
$response->assertCannotView();
$response->assertCannotUpdate();
$response->assertCannotDelete();
$response->assertCannotForceDelete();
$response->assertCannotRestore();
```