<?php

namespace OpenSynergic\Hooks\Facades;

use Illuminate\Support\Facades\Facade;
use OpenSynergic\Hooks\HookManager;

/**
 * @see \OpenSynergic\Hooks\HookManager
 * @method static void register(string $name, Closure|string|array $callback, int $sequence = 0)
 * @method static bool call(string $name, mixed $arguments)
 * @method static array getHooks()
 * @method static array getHookByName(string $name)
 * @method static void clear(string $name)
 */
class Hook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HookManager::class;
    }
}
