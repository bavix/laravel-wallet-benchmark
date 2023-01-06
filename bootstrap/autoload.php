<?php

declare(strict_types=1);

use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Interfaces\ProductLimitedInterface;

include_once dirname(__DIR__) . '/vendor/autoload.php';

if (!interface_exists(Product::class)) {
    class_alias(ProductLimitedInterface::class, Product::class);
}
