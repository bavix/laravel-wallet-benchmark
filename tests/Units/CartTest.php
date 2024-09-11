<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Objects\Cart;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Factories\ItemFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\Models\Item;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class CartTest extends TestCase
{
    /**
     * @dataProvider x25
     */
    public function testPay(): void
    {
        /**
         * @var Buyer  $buyer
         * @var Item[] $products
         */
        $buyer = BuyerFactory::new()->create();
        $products = ItemFactory::times(50)->create([
            'quantity' => 1,
        ]);

        if (method_exists(app(Cart::class), 'withItems')) {
            $transfers = $buyer->wallet->forcePayCart(app(Cart::class)->withItems($products));
        } else {
            $transfers = $buyer->wallet->forcePayCart(app(Cart::class)->addItems($products));
        }

        self::assertCount(50, $transfers);
        foreach ($transfers as $transfer) {
            self::assertTrue($buyer->wallet->is($transfer->from));
            self::assertTrue($transfer->deposit->confirmed);
            self::assertTrue($transfer->withdraw->confirmed);
        }
    }

    /**
     * @dataProvider x25
     */
    public function testPayFree(): void
    {
        /**
         * @var Buyer  $buyer
         * @var Item[] $products
         */
        $buyer = BuyerFactory::new()->create();
        $products = ItemFactory::times(50)->create([
            'quantity' => 1,
        ]);

        if (method_exists(app(Cart::class), 'withItems')) {
            $transfers = $buyer->wallet->payFreeCart(app(Cart::class)->withItems($products));
        } else {
            $transfers = $buyer->wallet->payFreeCart(app(Cart::class)->addItems($products));
        }

        self::assertCount(50, $transfers);
        foreach ($transfers as $transfer) {
            self::assertTrue($buyer->wallet->is($transfer->from));
            self::assertTrue($transfer->deposit->confirmed);
            self::assertTrue($transfer->withdraw->confirmed);
        }
    }

    /**
     * @dataProvider x25
     */
    public function testPayOneItemXPieces(): void
    {
        $quantity = 30;
        $buyer = BuyerFactory::new()->create();
        $product = ItemFactory::new()->create([
            'quantity' => $quantity,
        ]);

        $cart = app(Cart::class);
        if (method_exists($cart, 'withItems')) {
            for ($i = 0; $i < $quantity; ++$i) {
                $cart = $cart->withItem($product);
            }
        } else {
            for ($i = 0; $i < $quantity; ++$i) {
                $cart->addItem($product);
            }
        }

        $transfers = $buyer->wallet->forcePayCart($cart);
        self::assertCount($quantity, $transfers);
        foreach ($transfers as $transfer) {
            self::assertTrue($buyer->wallet->is($transfer->from));
            self::assertTrue($transfer->deposit->confirmed);
            self::assertTrue($transfer->withdraw->confirmed);
        }
    }

    /**
     * @dataProvider x25
     */
    public function testEagerLoaderPay(): void
    {
        /**
         * @var Buyer  $buyer
         * @var Item[] $products
         */
        $buyer = BuyerFactory::new()->create();
        $products = ItemFactory::times(50)->create([
            'quantity' => 5,
            'price' => 1,
        ]);

        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getKey();
            self::assertSame(0, (int) $product->balance);
            self::assertTrue($product->wallet->saveQuietly());
            self::assertTrue($product->wallet->exists);
        }

        /** @var Product[] $products */
        $products = Item::query()->whereKey($productIds)->get()->all();

        $cart = app(Cart::class);
        if (method_exists($cart, 'withItem')) {
            foreach ($products as $product) {
                $cart = $cart->withItem($product, 5);
            }
        } else {
            foreach ($products as $product) {
                $cart->addItem($product, 5);
            }
        }

        $transfers = $buyer->forcePayCart($cart);
        self::assertSame((int) -$cart->getTotal($buyer), (int) $buyer->balance);
        self::assertCount(250, $transfers);
    }
}
