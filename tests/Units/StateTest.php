<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Internal\Service\DatabaseService;
use Bavix\Wallet\Internal\Service\DatabaseServiceInterface;
use Bavix\Wallet\Services\BookkeeperServiceInterface;
use Bavix\Wallet\Internal\StorageInterface;
use Bavix\Wallet\Internal\BookkeeperInterface;
use Bavix\Wallet\Services\BookkeeperService;
use Bavix\Wallet\Services\DbService;
use Bavix\Wallet\Services\RegulatorService;
use Bavix\Wallet\Services\RegulatorServiceInterface;
use Bavix\Wallet\Services\StorageService;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class StateTest extends TestCase
{
    /**
     * @dataProvider x25
     */
    public function testInTransaction(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        $callback = static function () use ($buyer) {
            for ($i = 0; $i < 256; ++$i) {
                $buyer->wallet->depositFloat(0.01);
            }
        };

        if (class_exists(DatabaseService::class)) {
            app(DatabaseServiceInterface::class)->transaction($callback);
        } elseif (class_exists(DbService::class)) {
            if (class_exists(BookkeeperService::class)) {
                app(BookkeeperInterface::class)->missing($buyer->wallet);
            }

            if (class_exists(StorageService::class)) {
                app(StorageInterface::class)->flush();
            }

            app(DbService::class)->transaction($callback);
        } else {
            $this->markTestSkipped();
        }

        self::assertSame(256, (int) $buyer->balance);
    }

    /**
     * @dataProvider x25
     */
    public function testTransactionRollback(): void
    {
        // laravel-wallet <7.1
        if (!class_exists(RegulatorService::class)) {
            $this->markTestSkipped();
        }

        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        self::assertFalse($buyer->relationLoaded('wallet'));
        $wallet = $buyer->wallet;

        self::assertFalse($wallet->exists);
        self::assertSame(0, (int) $wallet->balance);

        $bookkeeper = app(BookkeeperServiceInterface::class);
        $regulator = app(RegulatorServiceInterface::class);

        $wallet->deposit(1000);
        self::assertSame(0, (int) $regulator->diff($wallet));
        self::assertSame(1000, (int) $regulator->amount($wallet));
        self::assertSame(1000, (int) $bookkeeper->amount($wallet));
        self::assertSame(1000, (int) $wallet->balance);

        app(DatabaseServiceInterface::class)->transaction(function () use ($wallet, $regulator, $bookkeeper) {
            $wallet->deposit(10000);
            self::assertSame(10000, (int) $regulator->diff($wallet));
            self::assertSame(11000, (int) $regulator->amount($wallet));
            self::assertSame(1000, (int) $bookkeeper->amount($wallet));

            return false; // rollback
        });

        self::assertSame(0, (int) $regulator->diff($wallet));
        self::assertSame(1000, (int) $regulator->amount($wallet));
        self::assertSame(1000, (int) $bookkeeper->amount($wallet));
        self::assertSame(1000, (int) $wallet->balance);
    }

    /**
     * @dataProvider x25
     */
    public function testRefreshInTransaction(): void
    {
        // laravel-wallet <7.1
        if (!class_exists(RegulatorService::class)) {
            $this->markTestSkipped();
        }

        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        $buyer->deposit(10000);

        $bookkeeper = app(BookkeeperServiceInterface::class);
        $regulator = app(RegulatorServiceInterface::class);

        $bookkeeper->increase($buyer->wallet, 100);
        self::assertSame(10100, (int) $buyer->balance);

        app(DatabaseServiceInterface::class)->transaction(function () use ($bookkeeper, $regulator, $buyer) {
            self::assertTrue($buyer->wallet->refreshBalance());
            self::assertSame(-100, (int) $regulator->diff($buyer->wallet));
            self::assertSame(10100, (int) $bookkeeper->amount($buyer->wallet));
            self::assertSame(10000, (int) $buyer->balance); // bookkeeper.amount+regulator.diff

            return false; // rollback. cancel refreshBalance
        });

        self::assertSame(0, (int) $regulator->diff($buyer->wallet));
        self::assertSame(10100, (int) $bookkeeper->amount($buyer->wallet));
        self::assertSame(10100, (int) $buyer->balance);

        app(DatabaseServiceInterface::class)->transaction(function () use ($bookkeeper, $regulator, $buyer) {
            self::assertTrue($buyer->wallet->refreshBalance());
            self::assertSame(-100, (int) $regulator->diff($buyer->wallet));
            self::assertSame(10100, (int) $bookkeeper->amount($buyer->wallet));
            self::assertSame(10000, (int) $buyer->balance); // bookkeeper.amount+regulator.diff

            return []; // if count() === 0 then rollback. cancel refreshBalance
        });

        self::assertSame(0, (int) $regulator->diff($buyer->wallet));
        self::assertSame(10100, (int) $bookkeeper->amount($buyer->wallet));
        self::assertSame(10100, (int) $buyer->balance);

        self::assertTrue($buyer->wallet->refreshBalance());

        self::assertSame(0, (int) $regulator->diff($buyer->wallet));
        self::assertSame(10000, (int) $bookkeeper->amount($buyer->wallet));
        self::assertSame(10000, (int) $buyer->balance);
    }
}
