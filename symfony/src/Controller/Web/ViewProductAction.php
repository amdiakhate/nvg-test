<?php

namespace App\Controller\Web;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ViewProductAction
{

    private ProductRepository $productRepository;
    private Environment $templating;

    private const PAGE_SIZE = 30;

    /**
     * ListProductsAction constructor.
     * @param ProductRepository $productRepository
     * @param Environment $templating
     */
    public function __construct(ProductRepository $productRepository, Environment $templating)
    {
        $this->productRepository = $productRepository;
        $this->templating = $templating;
    }


    /**
     * @param Request $request
     * @param Product $product
     */
    public function __invoke(Request $request, int $id)
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        if (null === $product) {
            throw new NotFoundHttpException();
        }
        return new Response($this->templating->render('product/view.html.twig', ['product' => $product]));
    }
}