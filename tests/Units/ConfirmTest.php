<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class ConfirmTest extends TestCase
{
    /**
     * @dataProvider x25
     */
    public function testConfirm(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        $deposit = $buyer->deposit(100, confirmed: false);

        self::assertTrue($buyer->wallet->confirm($deposit));
    }

    /**
     * @dataProvider x25
     */
    public function testUnConfirm(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        $deposit = $buyer->deposit(100);

        self::assertTrue($buyer->wallet->resetConfirm($deposit));
    }
}
