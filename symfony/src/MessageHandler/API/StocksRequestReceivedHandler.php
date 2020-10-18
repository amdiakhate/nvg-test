<?php

namespace App\MessageHandler\API;

use App\Message\API\ProductsRequestReceivedMessage;
use App\Message\API\StockRequestReceivedMessage;
use App\Service\API\ProductRequestService;
use App\Service\API\StockRequestService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class StocksRequestReceivedHandler implements MessageHandlerInterface
{
    private StockRequestService $stockRequestService;

    /**
     * StocksRequestReceivedHandler constructor.
     * @param StockRequestService $stockRequestService
     */
    public function __construct(StockRequestService $stockRequestService)
    {
        $this->stockRequestService = $stockRequestService;
    }


    public function __invoke(StockRequestReceivedMessage $stockRequestReceivedMessage)
    {
        foreach ($stockRequestReceivedMessage->getStocksRequest() as $stockRequest) {
            $this->stockRequestService->updateInventory($stockRequest);
        }
    }
}