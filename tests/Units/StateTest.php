<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Internal\Service\DatabaseServiceInterface;
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

        app(DatabaseServiceInterface::class)->transaction(static function () use ($buyer) {
            for ($i = 0; $i < 256; ++$i) {
                $buyer->wallet->depositFloat(0.01);
            }
        });

        self::assertSame(256, (int) $buyer->balance);
    }
}
