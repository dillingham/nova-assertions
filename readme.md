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

### Authentication
Must act as a logged in user with access to Nova
```php
$this->be(factory(User::class)->create());
```

### Requests

- ->novaIndex($resource)
- ->novaDetail($resource, $id)
- ->novaCreate($resource)
- ->novaEdit($resource, $id)

<!-- TODO: -->
->novaBelongsTo('workflows', $id, 'users')
    ->assertRelation($user->id, 'Brian')

### Assert Fields

- ->assertFieldExists($attribute)
- ->assertFieldEquals($attribute, $value)

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