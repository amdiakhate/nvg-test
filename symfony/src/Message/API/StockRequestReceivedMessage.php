<?php

namespace App\Message\API;

use App\Model\API\StockRequest;

class StockRequestReceivedMessage
{
    /**
     * StockRequestReceivedMessage constructor.
     * @param StockRequest[] $stocksRequest
     */
    public function __construct(array $stocksRequest)
    {
        $this->stocksRequest = $stocksRequest;
    }

    /**
     * @return StockRequest[]
     */
    public function getStocksRequest(): array
    {
        return $this->stocksRequest;
    }

    /**
     * @var StockRequest[] $stocksRequest
     */
    private array $stocksRequest;

}