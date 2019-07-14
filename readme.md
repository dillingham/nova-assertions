# Nova Assertions

Work in progress. Not functional yet.

### Installation

```
composer require dillingham/nova-test-requests
```
```php
use NovaTesting\NovaRequests;

class UserTest extends TestCase
{
    use NovaRequests;

    public function testNova()
    {
        $this->be(factory(User::class)->create());

        $this->novaDetail('users', $user->id);
            ->assertFieldEquals('email', $user->email);
            ->assertCanUpdate()
            ->assertCannotDelete();
    }
}
```

### Requests

- ->novaIndex($resource)
- ->novaDetail($resource, $id)

### Assert Fields

- ->assertFieldExists($attribute)
- ->assertFieldEquals($attribute, $value)

### Assert Authorization

- ->assertCanDelete()
- ->assertCannotDelete()
- ->assertCanForceDelete()
- ->assertCannotForceDelete()
- ->assertCanRestore()
- ->assertCannotRestore()
- ->assertCanUpdate()
- ->assertCannotUpdate()
- ->assertCanView()
- ->assertCannotView()
- ->assertCanViewAny()
- ->assertCannotViewAny()