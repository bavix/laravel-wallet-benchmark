<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Infra;

use Bavix\Wallet\WalletServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * @internal
 */
class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::transactionLevel() && DB::rollBack();
    }

    /** @param Application $app */
    protected function getPackageProviders($app): array
    {
        return [WalletServiceProvider::class, TestServiceProvider::class];
    }

    /** @param Application $app */
    protected function getEnvironmentSetUp($app): void
    {
        /** @var Repository $config */
        $config = $app['config'];

        $config->set('wallet.cache.enabled', true); // for 6.x
        $config->set('wallet.cache.driver', $config->get('cache.driver'));
        $config->set('wallet.cache.cache', $config->get('cache.driver')); // for 6.x

        $config->set('wallet.lock.enabled', true); // for 6.x
        $config->set('wallet.lock.driver', $config->get('cache.driver'));
        $config->set('wallet.lock.cache', $config->get('cache.driver')); // for 6.x
    }

    // benchmark
    protected function x25(): iterable
    {
        yield from $this->iterate(25);
    }

    protected function x100(): iterable
    {
        yield from $this->iterate(100);
    }

    protected function x300(): iterable
    {
        yield from $this->iterate(300);
    }

    private function iterate(int $value): iterable
    {
        for ($i = 0; $i < $value; ++$i) {
            yield [];
        }
    }
}
