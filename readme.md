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

| Assertion | Description |
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