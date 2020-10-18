<?php

namespace App\MessageHandler\API;

use App\Message\API\ProductsRequestReceivedMessage;
use App\Service\API\ProductRequestService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProductsRequestReceivedHandler implements MessageHandlerInterface
{
    private ProductRequestService $productRequestService;

    /**
     * ProductsRequestReceivedHandler constructor.
     * @param ProductRequestService $productRequestService
     */
    public function __construct(ProductRequestService $productRequestService)
    {
        $this->productRequestService = $productRequestService;
    }

    public function __invoke(ProductsRequestReceivedMessage $productsRequestReceivedMessage)
    {
        foreach ($productsRequestReceivedMessage->getProductsRequest() as $productRequest) {
            $this->productRequestService->updateProduct($productRequest);
        }
    }
}