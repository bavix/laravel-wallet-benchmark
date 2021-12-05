<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Objects\Cart;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Factories\ItemFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\Models\Item;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
class CartTest extends TestCase
{
    /** @dataProvider x25 */
    public function testPay(): void
    {
        /**
         * @var Buyer  $buyer
         * @var Item[] $products
         */
        $buyer = BuyerFactory::new()->create();
        $products = ItemFactory::times(50)->create(['quantity' => 1]);

        self::assertCount(50, $buyer->forcePayCart(app(Cart::class)->addItems($products)));
    }

    /** @dataProvider x25 */
    public function testPayFree(): void
    {
        /**
         * @var Buyer  $buyer
         * @var Item[] $products
         */
        $buyer = BuyerFactory::new()->create();
        $products = ItemFactory::times(50)->create(['quantity' => 1]);

        self::assertCount(50, $buyer->payFreeCart(app(Cart::class)->addItems($products)));
    }
}
