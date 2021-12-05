<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
class SoloTest extends TestCase
{
    /** @dataProvider x300 */
    public function testGetBalance(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        self::assertSame(0, (int) $buyer->balance);
    }

    /** @dataProvider x100 */
    public function testDeposit(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        self::assertNotNull($buyer->deposit(1));
    }

    /** @dataProvider x100 */
    public function testForceWithdraw(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        self::assertNotNull($buyer->forceWithdraw(1));
    }

    /** @dataProvider x100 */
    public function testTransfer(): void
    {
        /**
         * @var Buyer $buyer1
         * @var Buyer $buyer2
         */
        [$buyer1, $buyer2] = BuyerFactory::times(2)->create();
        $buyer1->deposit(100); // deposit

        self::assertNotNull($buyer1->transfer($buyer2, 100));
    }
}
