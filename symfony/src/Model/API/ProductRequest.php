<?php

namespace App\Model\API;

class ProductRequest implements RequestObject
{
    public string $reference;
    public string $name;
    public ?string $dropshipping;
    public ?string $category;
    public ?string $description;
    /**
     * @var PricingRequest[]
     */
    public $pricing;

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDropshipping(): ?string
    {
        return $this->dropshipping;
    }


    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return PricingRequest[]
     */
    public function getPricing(): array
    {
        return $this->pricing;
    }


}