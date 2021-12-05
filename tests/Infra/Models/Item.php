<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Infra\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item.
 *
 * @property string $name
 * @property int    $quantity
 * @property int    $price
 */
class Item extends Model implements Product
{
    use HasWallet;

    protected $fillable = ['name', 'quantity', 'price'];

    public function canBuy(Customer $customer, int $quantity = 1, bool|null $force = false): bool
    {
        $result = $this->quantity >= $quantity;

        if ($force) {
            return $result;
        }

        return $result && !$customer->paid($this);
    }

    public function getAmountProduct(Customer $customer)
    {
        return $this->price;
    }

    public function getMetaProduct(): ?array
    {
        return null;
    }

    public function getUniqueId(): string
    {
        return (string) $this->getKey();
    }
}
