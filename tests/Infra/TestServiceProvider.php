<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Infra;

use Illuminate\Support\ServiceProvider;

final class TestServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom([dirname(__DIR__, 2).'/migrations']);
    }
}
