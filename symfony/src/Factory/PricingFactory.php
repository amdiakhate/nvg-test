<?php

namespace App\Factory;

use App\Entity\Channel;
use App\Entity\Pricing;
use App\Entity\Product;
use App\Repository\ChannelRepository;
use App\Repository\PricingRepository;
use Doctrine\ORM\EntityManagerInterface;

class PricingFactory
{

    private PricingRepository $pricingRepository;
    private EntityManagerInterface $entityManager;

    /**
     * ChannelService constructor.
     * @param ChannelRepository $channelRepository
     */
    public function __construct(PricingRepository $pricingRepository, EntityManagerInterface $entityManager)
    {
        $this->pricingRepository = $pricingRepository;
        $this->entityManager = $entityManager;
    }


    public function getOrCreatePricing(Product $product, Channel $channel): Pricing
    {
        $pricing = $this->pricingRepository->findOneBy(['product' => $product, 'channel' => $channel]);
        if (null === $pricing) {
            $pricing = new Pricing($channel, $product);
//            $this->entityManager->persist($pricing);
//            $this->entityManager->flush();
        }

        return $pricing;
    }
}