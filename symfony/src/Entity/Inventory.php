<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="inventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity=Channel::class)
     */
    private $channel;

    /**
     * @ORM\OneToMany(targetEntity=Inbound::class, mappedBy="inventory", orphanRemoval=true)
     */
    private $inbounds;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $channelHash;

    public function __construct()
    {
        $this->channel = new ArrayCollection();
        $this->inbounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|Channel[]
     */
    public function getChannel(): Collection
    {
        return $this->channel;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channel->contains($channel)) {
            $this->channel[] = $channel;
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channel->contains($channel)) {
            $this->channel->removeElement($channel);
        }

        return $this;
    }

    /**
     * @return Collection|Inbound[]
     */
    public function getInbounds(): Collection
    {
        return $this->inbounds;
    }

    public function addInbound(Inbound $inbound): self
    {
        if (!$this->inbounds->contains($inbound)) {
            $this->inbounds[] = $inbound;
            $inbound->setInventory($this);
        }

        return $this;
    }

    public function removeInbound(Inbound $inbound): self
    {
        if ($this->inbounds->contains($inbound)) {
            $this->inbounds->removeElement($inbound);
            // set the owning side to null (unless already changed)
            if ($inbound->getInventory() === $this) {
                $inbound->setInventory(null);
            }
        }

        return $this;
    }

    public function getChannelHash(): ?string
    {
        return $this->channelHash;
    }

    public function setChannelHash(string $channelHash): self
    {
        $this->channelHash = $channelHash;

        return $this;
    }
}
