<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class SoloTest extends TestCase
{
    /**
     * @dataProvider x300
     */
    public function testGetBalance(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        self::assertSame(0, (int) $buyer->wallet->balance);
    }

    /**
     * @dataProvider x25
     */
    public function testEagerLoading(): void
    {
        $ids = [];
        $buyers = BuyerFactory::times(100)->create();
        foreach ($buyers as $buyer) {
            $buyer->wallet->deposit(100);
            $ids[] = $buyer->getKey();
        }

        /** @var Buyer[] $buyers */
        $buyers = Buyer::with('wallet')
            ->whereKey($ids)
            ->get()
        ;

        foreach ($buyers as $buyer) {
            self::assertSame(100, (int) $buyer->wallet->balance);
        }
    }

    /**
     * @dataProvider x100
     */
    public function testDeposit(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        $transaction = $buyer->wallet->deposit(1);

        self::assertNotNull($transaction);
        self::assertSame(1, (int) $transaction->amount);
        self::assertTrue($buyer->wallet->is($transaction->wallet));
        self::assertTrue($buyer->is($transaction->payable));
    }

    /**
     * @dataProvider x100
     */
    public function testForceWithdraw(): void
    {
        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();
        $transaction = $buyer->wallet->forceWithdraw(1);

        self::assertNotNull($transaction);
        self::assertSame(-1, (int) $transaction->amount);
        self::assertTrue($buyer->wallet->is($transaction->wallet));
        self::assertTrue($buyer->is($transaction->payable));
    }

    /**
     * @dataProvider x100
     */
    public function testTransfer(): void
    {
        /**
         * @var Buyer $buyer1
         * @var Buyer $buyer2
         */
        [$buyer1, $buyer2] = BuyerFactory::times(2)->create();
        $transaction = $buyer1->deposit(100); // deposit

        self::assertNotNull($transaction);
        self::assertSame(100, (int) $transaction->amount);
        self::assertTrue($buyer1->wallet->is($transaction->wallet));
        self::assertTrue($buyer1->is($transaction->payable));

        $transfer = $buyer1->wallet->transfer($buyer2->wallet, 100);

        self::assertNotNull($transfer);
        self::assertTrue($buyer1->wallet->is($transfer->from));
        self::assertTrue($buyer2->wallet->is($transfer->to));
        self::assertTrue($transfer->deposit->confirmed);
        self::assertTrue($transfer->withdraw->confirmed);
    }
}
