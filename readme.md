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

        $this->novaIndex('users')
            ->assertCanUpdate()
            ->assertCannotDelete()
            ->assertFieldsInclude('email')
            ->assertFieldsExclude('password');
    }
}
```

### Authentication
Log in a user that **[has access to Nova](https://nova.laravel.com/docs/2.0/installation.html#authorizing-nova)**
```php
$this->be(factory(User::class)->create());
```

### Nova Requests

Request Nova's results with one of the following:

```php
$response = $this->novaIndex('users');
```
```php
$response = $this->novaDetail('users', $user->id);
```
```php
$response = $this->novaCreate('users');
```
```php
$response = $this->novaEdit('users', $user->id);
```

TODO:: Add filtering & query params
->novaIndex('posts', [
    Filter::class => 'value'
]);


### Assert Http
You can call **[http response methods](https://laravel.com/docs/5.8/http-tests#available-assertions)** as usual:

```php
$response->assertOk();
```

### Assert Policies

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

### Assert Cards
```php
$response->assertCardsInclude('card-uri-key');
$response->assertCardsExclude('card-uri-key');
```

### Assert Actions
```php
$response->assertActionsInclude('action-uri-key');
$response->assertActionsExclude('action-uri-key');
```
### Assert Resource Count
```php
$response->assertResourceCount(3);
```
### Assert Fields

Assert columns or form fields with the following:

a specific field exists
```php
$response->assertFieldsInclude('id');
```
a specific field contains a value
```php
$response->assertFieldsInclude('id', $user->id);
```
multiple fields exist
```php
$response->assertFieldsInclude(['id', 'email']);
```
multiple fields and their values
```php
$response->assertFieldsInclude(['id' => 1, 'email' => 'example']);
```
multiple values for one field / index column
```php
$response->assertFieldsInclude('id', $users->pluck('id));
```
You can also do the inverse with exclude
```php
$response->assertFieldsExclude('id');
$response->assertFieldsExclude('id', $user->id);
$response->assertFieldsExclude(['id', 'email']);
$response->assertFieldsExclude(['id' => 1, 'email' => 'example']);
$response->assertFieldsExclude('id, $users->pluck('id));
```