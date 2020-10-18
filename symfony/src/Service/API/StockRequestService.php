<?php


namespace App\Service\API;


use App\Entity\Inbound;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Factory\ChannelFactory;
use App\Factory\InventoryFactory;
use App\Factory\PricingFactory;
use App\Factory\ProductFactory;
use App\Model\API\InboundRequest;
use App\Model\API\ProductRequest;
use App\Model\API\StockRequest;
use Assert\Assertion;
use Doctrine\ORM\EntityManagerInterface;

class StockRequestService
{

    private EntityManagerInterface $entityManager;
    private InventoryFactory $inventoryFactory;

    /**
     * StockRequestService constructor.
     * @param EntityManagerInterface $entityManager
     * @param InventoryFactory $inventoryFactory
     */
    public function __construct(EntityManagerInterface $entityManager, InventoryFactory $inventoryFactory)
    {
        $this->entityManager = $entityManager;
        $this->inventoryFactory = $inventoryFactory;
    }


    /**
     * @param StockRequest $stockRequest
     * @throws \Assert\AssertionFailedException
     */
    public function updateInventory(StockRequest $stockRequest): void
    {
        foreach ($stockRequest->getInventories() as $inventoryRequest) {
            $inventory = $this->inventoryFactory->fromInventoryRequest($inventoryRequest, $stockRequest->getReference());
            if (null !== $inventory) {
                $this->createInbounds($inventory, $inventoryRequest->getInbounds());
            }
        }

    }

    /**
     * @param Inventory $inventory
     * @param InboundRequest[] $inboundsRequest
     */
    public function createInbounds(Inventory $inventory, array $inboundsRequest)
    {

        foreach ($inboundsRequest as $inboundRequest) {
            $inbound = new Inbound();
            $inbound->setInventory($inventory);
            $inbound->setQuantity($inboundRequest->getQuantity());
            $inbound->setArrivalDate($inboundRequest->getArrivalDate());

            $this->entityManager->persist($inbound);
        }

        $this->entityManager->flush();

    }

}