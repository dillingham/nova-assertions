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
$response = $this->novaIndex('users', [
    StatusFilter::class => 'active'
]);
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
```
```php
$response->assertCardsExclude('card-uri-key');
```

### Assert Actions
```php
$response->assertActionsInclude('action-uri-key');
```
```php
$response->assertActionsExclude('action-uri-key');
```
### Assert Filters

```php
$response->assertFiltersInclude(Filter::class);
```
```php
$response->assertFiltersExclude(Filter::class);
```

### Assert Resource Count
```php
$response->assertResourceCount(3);
```
### Assert Fields

Assert a specific field exists
```php
$response->assertFieldsInclude('id');
```
Assert a specific field contains a value
```php
$response->assertFieldsInclude('id', $user->id);
```
Assert multiple fields exist
```php
$response->assertFieldsInclude(['id', 'email']);
```
Assert multiple fields with specific values exist
```php
$response->assertFieldsInclude(['id' => 1, 'email' => 'example']);
```
Assert multiple values for one field exist
```php
$response->assertFieldsInclude('id', $users->pluck('id));
```
Assert fields don't exist
```php
$response->assertFieldsExclude('id');
$response->assertFieldsExclude('id', $user->id);
$response->assertFieldsExclude(['id', 'email']);
$response->assertFieldsExclude(['id' => 1, 'email' => 'example']);
$response->assertFieldsExclude('id, $users->pluck('id));
```