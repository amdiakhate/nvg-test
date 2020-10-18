<?php

namespace App\Factory;

use App\Entity\Channel;
use App\Repository\ChannelRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChannelFactory
{

    private ChannelRepository $channelRepository;
    private EntityManagerInterface $entityManager;

    /**
     * ChannelService constructor.
     * @param ChannelRepository $channelRepository
     */
    public function __construct(ChannelRepository $channelRepository, EntityManagerInterface $entityManager)
    {
        $this->channelRepository = $channelRepository;
        $this->entityManager = $entityManager;
    }


    public function getOrCreateChannel(string $name): Channel
    {
        $channel = $this->channelRepository->findOneBy(['name' => $name]);
        if (null === $channel) {
            $channel = new Channel($name);
            $this->entityManager->persist($channel);
            $this->entityManager->flush();
        }

        return $channel;
    }
}