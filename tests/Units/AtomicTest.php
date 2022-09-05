<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Units;

use Bavix\Wallet\Services\AtomicService;
use Bavix\Wallet\Services\AtomicServiceInterface;
use Bavix\WalletBench\Test\Infra\Factories\BuyerFactory;
use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Bavix\WalletBench\Test\Infra\TestCase;

/**
 * @internal
 */
final class AtomicTest extends TestCase
{
    /**
     * @dataProvider x25
     */
    public function testBlocks(): void
    {
        if (!class_exists(AtomicService::class)) {
            $this->markTestSkipped();
        }

        /** @var AtomicServiceInterface $atomic */
        $atomic = $this->app->get(AtomicServiceInterface::class);

        // laravel-wallet <9.2
        if (!method_exists($atomic, 'blocks')) {
            $this->markTestSkipped();
        }

        /** @var Buyer $buyer */
        $buyer = BuyerFactory::new()->create();

        $callback = static function () use ($buyer) {
            for ($i = 0; $i < 256; ++$i) {
                $buyer->wallet->depositFloat(0.01);
            }
        };

        $atomic->block($buyer, $callback);

        self::assertSame(256, (int) $buyer->balance);
    }
}
