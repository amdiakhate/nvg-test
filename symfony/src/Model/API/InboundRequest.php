<?php


namespace App\Model\API;

class InboundRequest
{
    public string $arrival_date;
    public int $quantity;

    /**
     * @return \DateTime
     */
    public function getArrivalDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->arrival_date);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

}