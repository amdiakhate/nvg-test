<?php


namespace App\Factory;


use App\Entity\Inbound;
use App\Entity\Inventory;
use App\Model\API\InventoryRequest;
use App\Repository\ChannelRepository;
use App\Repository\InventoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class InventoryFactory
{
    use LoggerAwareTrait;

    private InventoryRepository $inventoryRepository;
    private ProductRepository $productRepository;
    private ChannelRepository $channelRepository;
    private EntityManagerInterface $entityManager;

    /**
     * InventoryFactory constructor.
     * @param InventoryRepository $inventoryRepository
     * @param ProductRepository $productRepository
     * @param ChannelRepository $channelRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, InventoryRepository $inventoryRepository, ProductRepository $productRepository, ChannelRepository $channelRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->productRepository = $productRepository;
        $this->channelRepository = $channelRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param InventoryRequest $inventoryRequest
     * @param string $productReference
     * @return Inventory|null
     */
    public function fromInventoryRequest(InventoryRequest $inventoryRequest, string $productReference): ?Inventory
    {
        $channels = $inventoryRequest->getChannels();
        $channelHash = md5(serialize($channels));
        $product = $this->productRepository->findOneBy(['reference' => $productReference]);
        if (null === $product) {
            $this->logger->error(sprintf('Product %s doesn\'t exist', $productReference));
            return null;
        }
        $inventory = $this->inventoryRepository->findOneBy(['channelHash' => $channelHash, 'product' => $product]) ?? new Inventory();

        if (null === $inventory->getId()) {
//            new inventory, let's add the channels
            foreach ($channels as $channel) {
                $channelEntity = $this->channelRepository->findOneBy(['name' => $channel]);
                if (null !== $channelEntity) {
                    $inventory->addChannel($channelEntity);
                }
                $inventory->setChannelHash($channelHash);
            }
            $inventory->setProduct($product);

        }
        $inventory->setQuantity($inventoryRequest->getQuantity());

        $this->entityManager->persist($inventory);
        $this->entityManager->flush();

        return $inventory;
    }
}