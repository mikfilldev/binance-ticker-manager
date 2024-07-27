<?php

namespace app\Models;

class CurrencyPair
{
    private $symbol;
    private $price;

    public function __construct(string $symbol, float $price)
    {
        $this->symbol = $symbol;
        $this->price = $price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
