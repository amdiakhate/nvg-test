<?php

namespace App\Test\Service\API;

use App\Entity\Channel;
use App\Entity\Pricing;
use App\Entity\Product;
use App\Factory\ChannelFactory;
use App\Factory\PricingFactory;
use App\Factory\ProductFactory;
use App\Model\API\PricingRequest;
use App\Service\API\ProductRequestService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ProductRequestServiceTest extends TestCase
{

    private ProductFactory $productFactory;
    private ChannelFactory $channelFactory;
    private PricingFactory $pricingFactory;
    private EntityManagerInterface $entityManager;

//
    public function setUp()
    {
//        best to not mock it and do a functional test with the db
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->productFactory = $this->createMock(ProductFactory::class);
        $this->pricingFactory = $this->createMock(PricingFactory::class);
        $this->channelFactory = $this->createMock(ChannelFactory::class);

    }

    public function testUpdatePricing()
    {
        $pricingRequest = new PricingRequest();
        $pricingRequest->price = 10;
        $pricingRequest->vatRate = 15;
        $pricingRequest->channel = 'fr';
        $product = $this->createMock(Product::class);

        $pricingEntity = $this->createMock(Pricing::class);
        $pricingEntity->expects($this->once())
            ->method('setPrice')
            ->with($pricingRequest->getPrice());

        $pricingEntity->expects($this->once())
            ->method('setVat')
            ->with($pricingRequest->getVatRate());

        $channel = $this->createMock(Channel::class);
        $this->channelFactory->expects($this->once())
            ->method('getOrCreateChannel')
            ->with($pricingRequest->getChannel())
            ->willReturn($channel);

        $this->pricingFactory->expects($this->once())
            ->method('getOrCreatePricing')
            ->with($product, $channel)
            ->willReturn($pricingEntity);

        $productRequestService = new ProductRequestService($this->productFactory, $this->channelFactory, $this->pricingFactory, $this->entityManager);

        $productRequestService->updatePricing($pricingRequest, $product);
    }

}