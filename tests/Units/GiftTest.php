<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Models\Transfer;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Factories\ItemFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\Models\Item;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class GiftTest extends TestCase
{
    /**
     * @dataProvider x25
     */
    public function testGift(): void
    {
        /**
         * @var Buyer $first
         * @var Buyer $second
         * @var Item  $product
         */
        [$first, $second] = BuyerFactory::times(2)->create();
        $product = ItemFactory::new()->create([
            'quantity' => 1,
        ]);

        self::assertSame(0, (int) $first->balance);
        self::assertSame(0, (int) $second->balance);

        $first->deposit($product->getAmountProduct($first));
        self::assertSame((int) $first->balance, (int) $product->getAmountProduct($first));

        $transfer = $first->wallet->gift($second, $product);
        self::assertSame(0, (int) $first->balance);
        self::assertSame(0, (int) $second->balance);
        self::assertNull($first->paid($product, true));
        self::assertNotNull($second->paid($product, true));
        self::assertNull($second->wallet->paid($product));
        self::assertNotNull($second->wallet->paid($product, true));
        self::assertSame(Transfer::STATUS_GIFT, $transfer->status);
    }

    /**
     * @dataProvider x25
     */
    public function testRefund(): void
    {
        /**
         * @var Buyer $first
         * @var Buyer $second
         * @var Item  $product
         */
        [$first, $second] = BuyerFactory::times(2)->create();
        $product = ItemFactory::new()->create([
            'quantity' => 1,
        ]);

        self::assertSame(0, (int) $first->balance);
        self::assertSame(0, (int) $second->balance);

        $first->deposit($product->getAmountProduct($first));
        self::assertSame((int) $product->getAmountProduct($first), (int) $first->balance);

        $transfer = $first->wallet->gift($second, $product);
        self::assertSame(0, (int) $first->balance);
        self::assertSame(0, (int) $second->balance);
        self::assertSame($transfer->status, Transfer::STATUS_GIFT);

        self::assertFalse($second->wallet->safeRefund($product));
        self::assertTrue($second->wallet->refundGift($product));

        self::assertSame((int) $product->getAmountProduct($first), (int) $first->balance);
        self::assertSame(0, (int) $second->balance);

        self::assertNull($second->wallet->safeGift($first, $product));

        $transfer = $second->wallet->forceGift($first, $product);
        self::assertNotNull($transfer);
        self::assertSame($transfer->status, Transfer::STATUS_GIFT);

        self::assertSame((int) $second->balance, (int) -$product->getAmountProduct($second));

        $second->deposit(-$second->balance);
        self::assertSame(0, (int) $second->balance);

        $first->withdraw($product->getAmountProduct($first));
        self::assertSame(0, (int) $first->balance);

        $product->withdraw($product->balance);
        self::assertSame(0, (int) $product->balance);

        self::assertFalse($first->safeRefundGift($product));
        self::assertTrue($first->forceRefundGift($product));
        self::assertSame((int) $product->balance, (int) -$product->getAmountProduct($second));

        self::assertSame((int) $product->getAmountProduct($second), (int) $second->balance);
        $second->withdraw($second->balance);
        self::assertSame(0, (int) $second->balance);
    }
}
