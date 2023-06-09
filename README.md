# Hook

Hook description.

## Installation

Install the package via composer:

```bash
composer require opensynergic/hooks
```

Done, Now you can use hooks

## Usage

Wherever you want, you can call a hook in your laravel application.

```php
use OpenSynergic\Hooks\Facades\Hook;

Hook::call('user_created', $user);
```

Here, `user_created` is the name of the hook, which will call all the hook registered with the same name. And `$user` is the parameters, which will be found whenever you register the new hook with the same name. These can be anything.

To register to your hook, you attach a callback function. These are best added to your `AppServiceProvider` `boot()` method.

For example if you wanted to hook in to the above hook, you could do:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenSynergic\Hooks\Facades\Hook;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    //...

    public function boot(): void
    {
      Hook::register('user_created', function($hookName, User $arguments){
        $arguments->sendEmailVerificationNotification();
      });
    }

}

```

## Example

`More example coming soon`
