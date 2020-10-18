<?php


namespace App\Model\API;


class StockRequest
{
    public string $reference;

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return InventoryRequest[]
     */
    public function getInventories(): array
    {
        return $this->inventories;
    }

    /**
     * @var InventoryRequest[] $inventories
     */
    public array $inventories;

}