<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Internal\Service\DatabaseService;
use Bavix\Wallet\Internal\Service\DatabaseServiceInterface;
use Bavix\Wallet\Services\DbService;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
class StateTest extends TestCase
{
    /** @dataProvider x25 */
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
            app(DbService::class)->transaction($callback);
        } else {
            self::markTestSkipped();
        }

        self::assertSame(256, (int) $buyer->balance);
    }
}
