<?php

namespace OpenSynergic\Hooks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HooksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hooks');

        $this->app->singleton(HookManager::class, function (): HookManager {
            return new HookManager();
        });
    }
}
