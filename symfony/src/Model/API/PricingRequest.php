<?php

namespace App\Model\API;

class PricingRequest implements RequestObject
{
    public string $channel;
    public int $vatRate;
    public int $price;

    /**
     * PricingRequest constructor.
     */
    public function __construct()
    {
        $this->vatRate = 0;
        $this->price = 0;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return int
     */
    public function getVatRate(): int
    {
        return $this->vatRate;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}