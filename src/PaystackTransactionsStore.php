<?php

namespace Digikraaft\PaystackTransactionsTile;

use Spatie\Dashboard\Models\Tile;

class PaystackTransactionsStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("paystackTransactions");
    }

    public function setData(array $data): self
    {
        $this->tile->putData('paystack.transactions', $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData('paystack.transactions') ?? [];
    }
}
