<?php


namespace App\Service\API;


use App\Entity\Pricing;
use App\Entity\Product;
use App\Factory\ChannelFactory;
use App\Factory\PricingFactory;
use App\Factory\ProductFactory;
use App\Model\API\PricingRequest;
use App\Model\API\ProductRequest;
use Assert\Assertion;
use Doctrine\ORM\EntityManagerInterface;

class ProductRequestService
{

    private ProductFactory $productFactory;
    private ChannelFactory $channelFactory;
    private PricingFactory $pricingFactory;
    private EntityManagerInterface $entityManager;

    /**
     * ProductRequestService constructor.
     * @param ProductFactory $productFactory
     * @param ChannelFactory $channelFactory
     * @param PricingFactory $pricingFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ProductFactory $productFactory, ChannelFactory $channelFactory, PricingFactory $pricingFactory, EntityManagerInterface $entityManager)
    {
        $this->productFactory = $productFactory;
        $this->channelFactory = $channelFactory;
        $this->pricingFactory = $pricingFactory;
        $this->entityManager = $entityManager;
    }

    public function updateProduct(ProductRequest $productRequest): void
    {
        $product = $this->productFactory->fromProductRequest($productRequest);
        Assertion::notNull($product);
        $this->updatePricings($productRequest, $product);

    }

    public function updatePricings(ProductRequest $productRequest, Product $product): void
    {
        //   On va créer les boutiques ici, en temps normal on le ferait dans le BO
        foreach ($productRequest->getPricing() as $pricing) {
            $this->updatePricing($pricing, $product);
        }
    }

    /**
     * @param PricingRequest $pricing
     * @param Product $product
     * @return Pricing
     */
    public function updatePricing(PricingRequest $pricing, Product $product): Pricing
    {
        $channel = $this->channelFactory->getOrCreateChannel($pricing->getChannel());
        $pricingEntity = $this->pricingFactory->getOrCreatePricing($product, $channel);

        $pricingEntity->setPrice($pricing->getPrice());
        $pricingEntity->setVat($pricing->getVatRate());
        $this->entityManager->persist($pricingEntity);

        return $pricingEntity;
    }
}