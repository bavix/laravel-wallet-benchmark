<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Infra;

use Bavix\Wallet\WalletServiceProvider;
use Bavix\WalletVacuum\VacuumServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * @internal
 */
abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::transactionLevel() && DB::rollBack();
    }

    // benchmark
    public static function x25(): iterable
    {
        yield from self::iterate(25);
    }

    public static function x100(): iterable
    {
        yield from self::iterate(100);
    }

    public static function x300(): iterable
    {
        yield from self::iterate(300);
    }

    /**
     * @param Application $app
     */
    protected function getPackageProviders($app): array
    {
        $results = [
            WalletServiceProvider::class,
        ];

        // for 6.x
        if (class_exists(VacuumServiceProvider::class)) {
            $results[] = VacuumServiceProvider::class;
        }

        return array_merge($results, [TestServiceProvider::class]);
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        /** @var Repository $config */
        $config = $app['config'];

        if ($config->get('database.connections.mariadb') === null) {
            $mysql = $config->get('database.connections.mysql');
            $config->set('database.connections.mariadb', array_merge($mysql, [
                'port' => 3307,
            ]));
        } else {
            $config->set('database.connections.mariadb.port', 3307);
        }

        $config->set('wallet.cache.driver', 'database');
        $config->set('wallet.lock.driver', 'database');
    }

    private static function iterate(int $value): iterable
    {
        $startAt = microtime(true);

        for ($i = 0; $i < $value; ++$i) {
            $tickTime = microtime(true);

            yield [];

            $current = microtime(true);

            if ((($current - $tickTime) > 5) || (($current - $startAt) > 60)) {
                break;
            }
        }
    }
}
