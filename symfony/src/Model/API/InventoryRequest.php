<?php

namespace App\Model\API;

class InventoryRequest implements RequestObject
{
    public array $channels;
    public int $quantity;
    /**
     * @var InboundRequest[] $inbounds
     */
    public array $inbounds ;

    /**
     * InventoryRequest constructor.
     */
    public function __construct()
    {
        $this->inbounds = [];
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return InboundRequest[]
     */
    public function getInbounds(): array
    {
        return $this->inbounds;
    }

}