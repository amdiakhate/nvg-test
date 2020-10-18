<?php


namespace App\Factory;


use App\Entity\Product;
use App\Model\API\ProductRequest;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductFactory
{

    private ProductRepository $productRepository;
    private ProductCategoryRepository $categoryRepository;
    private EntityManagerInterface $entityManager;

    /**
     * ProductFactory constructor.
     * @param ProductRepository $productRepository
     * @param ProductCategoryRepository $categoryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }


    public function fromProductRequest(ProductRequest $productRequest): Product
    {
        $product = $this->productRepository->findOneBy(['reference' => $productRequest->getReference()]) ?? new Product($productRequest->getName(), $productRequest->getReference());
        $category = $productRequest->getCategory() ?? $this->categoryRepository->findOneBy(['name' => $productRequest->getCategory()]);
        $product->setDropshipping("true" === $productRequest->getDropshipping());
        $product->setDescription($productRequest->getDescription());
        $product->setCategory($category);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;

    }
}