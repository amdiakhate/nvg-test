<?php

namespace App\Message\API;


use App\Model\API\ProductRequest;

class ProductsRequestReceivedMessage
{
    /**
     * @return ProductRequest[]
     */
    public function getProductsRequest(): array
    {
        return $this->productsRequest;
    }

    /**
     * @var ProductRequest[] $productsRequest
     */
    private array $productsRequest;

    /**
     * ProductsRequestReceivedMessage constructor.
     * @param ProductRequest[] $productsRequest
     */
    public function __construct(array $productsRequest)
    {
        $this->productsRequest = $productsRequest;
    }
}