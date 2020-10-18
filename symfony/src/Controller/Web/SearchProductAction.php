<?php


namespace App\Controller\Web;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchProductAction
{
    public ProductRepository $productRepository;

    /**
     * SearchProductAction constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(Request $request)
    {
        $term = $request->query->get('term');
        if (null !== $term) {
            $result = $this->productRepository->findByTerm($term);
            return new JsonResponse(['results' => $result]);
        }
        return new JsonResponse();

    }

}