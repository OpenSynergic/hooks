<?php

namespace OpenSynergic\Hooks;

use Closure;
use Throwable;

class HookManager
{
    /**
     * @var array
     */
    protected array $hooks = [];

    /**
     * The method to call hook.
     *
     * @var string
     */
    protected $method = 'handle';

    /**
     * Register Hook
     *
     * @param string $name
     * @param Closure|string|array $callback
     * @param int $sequence
     * 
     * @return void
     * 
     */
    public function register(string $name, Closure|string|array $callback, int $sequence = 0): void
    {
        $this->hooks[$name][$sequence][] = &$callback;
    }

    /**
     * Call Hook
     *
     * @param string $name
     * @param mixed $arguments
     * 
     * @return bool
     * 
     */
    public function call(string $name, mixed $arguments): bool
    {
        $hooks = $this->getHooks();
        if (!isset($hooks[$name])) {
            return false;
        }


        ksort($hooks[$name], SORT_NUMERIC);

        foreach ($hooks[$name] as $priority => $hookList) {
            foreach ($hookList as $hook) {
                try {
                    // Handle when only class name get passed
                    if (is_string($hook) && class_exists($hook)) {
                        $hook = $hook . '@' . $this->method;
                    }

                    if (app()->call($hook, ['arguments' => $arguments, 'hookName' => $name])) return true;
                } catch (\Throwable $th) {
                    $this->handleException($arguments, $th);
                }
            }
        }

        return false;
    }

    /**
     * Get All Available Hooks
     *
     * @return array
     * 
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * Get Available Hooks by Name
     *
     * @param string $name
     * 
     * @return array
     * 
     */
    public function getHookByName(string $name): array
    {
        return $this->hooks[$name] ?? [];
    }

    /**
     * Clear hook by name
     *
     * @param string $name
     * 
     * @return [type]
     * 
     */
    public function clear(string $name): void
    {
        if (isset($this->hooks[$name])) {
            unset($this->hooks[$name]);
        }
    }

    /**
     * Handle the given exception.
     *
     * @param  mixed  $passable
     * @param  \Throwable  $e
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function handleException(mixed $arguments, Throwable $e)
    {
        throw $e;
    }
}
